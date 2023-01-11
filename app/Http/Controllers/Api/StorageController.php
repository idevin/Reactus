<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Streamable;
use App\Http\Controllers\Controller;
use App\Models\StorageFile;
use App\Models\StorageTag;
use App\Models\Tag;
use App\Models\Tagged as TaggedModel;
use App\Models\User;
use App\Traits\Activity;
use App\Traits\Media;
use App\Traits\Storage;
use App\Traits\User as UserTrait;
use App\Traits\Utils;
use Cache;
use Carbon\Carbon;
use Conner\Tagging\Model\Tagged;
use Conner\Tagging\TaggingUtility;
use Exception;
use File;
use finfo;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use ImagickException;
use Symfony\Component\HttpFoundation\Response;
use Validator;
use ZipArchive;

class StorageController extends Controller
{
    /**
     * @activity done
     */
    use Media;
    use Utils;
    use Activity;
    use Storage;
    use UserTrait;

    public function __construct()
    {
        parent::__construct();
        $this->setObject(StorageFile::class);
        $this->setFromObject(User::class);
        $this->setFromObjectId($this->publicUser()->id);
        $this->setIsApi(true);
        $this->setIsSystem(true);
        $this->setActionsExcluded(['addBase64Files', 'addFiles', 'addImage', 'addImages',
            'addMultiTag', 'addTag', 'addUrl', 'attachTags', 'deleteBinFile', 'multiDownload',
            'multiRecycle', 'multiRecycleTags', 'recycle', 'removeTag', 'undeleteFile',
            'unfavoriteFile', 'updateUserTag', 'downloadZip', 'download', 'favorite',
            'deleteFile', 'favoriteFile', 'addChunkedFiles']);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     * @api {GET} /api/storage/recycle_bin Список удаленных обьектов в корзине
     * @apiGroup Storage
     *
     * @apiParam {string} token Ключ пользователя
     * @apiParam {integer} field Поле для сортировки (0 - title, 1 - created_at, 2 - size, 3 - original_filename, 4 -
     * favorite, 5 - id)
     * @apiParam {integer} order Порядок сортировки (0 - DESC, 1 - ASC)
     * @apiParam {string} term Фильтр по ключевому слову
     * @apiParam {string} tags Фильтр тегов (string, json, array)
     * @apiParam {array} objectType Фильтр типу обьекта (contact, link, event, file, image, audio, video, archive)
     * @apiParam {boolean} favorite Фильтр по избранным (1 - да, 0 - нет)
     * @apiParam {integer} page Номер страницы
     */
    public function recycleBin(Request $request): JsonResponse
    {
        return $this->objects($request, true);
    }

    /**
     * @param Request $request
     * @param bool $recycled
     * @return JsonResponse
     * @api {GET} /api/storage/objects Полный список обьектов
     * @apiGroup Storage
     *
     * @apiParam {string} token Ключ пользователя
     * @apiParam {integer} field Поле для сортировки (0 - title, 1 - created_at, 2 - size, 3 - original_filename, 4 -
     * favorite, 5 - id)
     * @apiParam {integer} order Порядок сортировки (0 - DESC, 1 - ASC)
     * @apiParam {string} term Фильтр по ключевому слову
     * @apiParam {string} tags Фильтр тегов (string, json, array)
     * @apiParam {array} objectType Фильтр типу обьекта (contact, link, event, file, image, audio, video, archive)
     * @apiParam {boolean} favorite Фильтр по избранным (1 - да, 0 - нет)
     * @apiParam {boolean} without_tags Обьекты без тегов (1 - да)
     * @apiParam {integer} page Номер страницы
     */
    public function objects(Request $request, bool $recycled = null): JsonResponse
    {
        $data = $request->all();
        $page = $request->get('page', 1);

        $user = Auth::user();

        if (!$user->hasPermission('sorage_access')) {
            return $this->error('У вас нет прав для входа в хранилище');
        }

        $objects = new LengthAwarePaginator(collect(), 0, 10);

        if (isset($data['tags']) && !empty($data['tags'])) {

            $taggedObjects = [];

            $data['tags'] = self::parseTags($data['tags']);

            if ($data['tags'] && count($data['tags']) > 0) {

                foreach ($data['tags'] as $tagArray) {
                    if (is_array($tagArray)) {
                        $objects = self::makeQuery($data, $recycled);
                        $tags = Tag::query()->whereIn('id', $tagArray)->get('name')->pluck('name')->toArray();
                        $objects = $objects->withAllTags($tags);
                        $objects = $objects->get();

                        foreach ($objects as $object) {
                            if (!in_array($object->id, array_keys($taggedObjects))) {
                                $taggedObjects[$object->id] = $object;
                            }
                        }
                    }
                }

                $taggedObjects = array_values($taggedObjects);

                $objects = new LengthAwarePaginator($taggedObjects, count($taggedObjects), 10, $page, [
                    'path' => $request->url(),
                    'query' => $request->query()
                ]);
            }
        } else {
            $objects = self::makeQuery($data, $recycled);
            $objects = $objects->paginate(10, ['*']);
        }

        $objects = Utils::transformUrl($objects);

        $objects->appends([
            'field' => $data['field'] ?? null,
            'order' => $data['order'] ?? null,
            'term' => $data['term'] ?? null,
            'page' => $page,
            'tags' => $data['tags'] ?? null,
            'objectType' => $data['objectType'] ?? null,
            'favorite' => $data['favorite'] ?? null,
            'token' => $this->publicUser()->auth_token
        ]);

        $objects->map(function ($object) {
            if ($object->tags && count($object->tags) > 0) {
                foreach ($object->tags as $tag) {
                    $tag?->makeHidden(['disabled', 'slug']);
                }
            }
            return $object->makeHidden(['path', 'user']);
        });

        return $this->success($objects);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {POST} /api/storage/multi_recycle Мультиудаление обьектов
     * @apiGroup Storage
     *
     * @apiParam {string} token Ключ пользователя
     * @apiParam {string} term Фильтр по ключевому слову
     * @apiParam {string} tags Фильтр по тегам через запятую
     * @apiParam {array} objectType Фильтр типу обьекта (contact, link, event, file, image, audio, video, archive)
     * @apiParam {boolean} favorite Фильтр по избранным (1 - да, 0 - нет)
     * @apiParam {boolean} delete_all Удаление всех обьектов
     * @apiParam {boolean} empty_trash Удаление всех обьектов из корзины
     * @apiParam {array} ids Массив ids обьектов (не обязательно)
     */
    public function multiRecycle(Request $request): JsonResponse
    {
        $data = $request->all();
        $objects = StorageFile::byUser($this->publicUser()->id);

        if (isset($data['ids']) && is_array($data['ids'])) {

            $existantObjects = array_map(function ($objectId) {
                $objectId = (int)$objectId;
                $object = StorageFile::byUser($this->publicUser()->id)->withTrashed()->find($objectId);
                return $object?->id;
            }, $data['ids']);

            $existantObjects = array_filter($existantObjects);

            if (count($existantObjects) > 0 && !isset($data['delete_all'])) {
                $objects = $objects->whereIn('id', $data['ids']);
            }
        }

        if (isset($data['term'])) {

            $data['term'] = Utils::cleanChars($data['term']);

            $objects = $objects->where(function ($query) use ($data) {
                $query->orWhere('title', 'LIKE', '%' . $data['term'] . '%')
                    ->orWhere('description', 'LIKE', '%' . $data['term'] . '%')
                    ->orWhere('filename', 'LIKE', '%' . $data['term'] . '%')
                    ->orWhere('original_filename', 'LIKE', '%' . $data['term'] . '%')
                    ->orWhere('url', 'LIKE', '%' . $data['term'] . '%');
            });
        }

        if (isset($data['objectType']) && is_array($data['objectType'])) {
            $objects = $objects->whereIn('object_type', $data['objectType']);
        }

        if (isset($data['tags']) && !empty($data['tags'])) {

            $tagData = self::parseTags($data['tags']);

            if (!empty($tagData)) {
                foreach ($tagData as $tagArray) {
                    if (is_array($tagArray)) {
                        $tags = Tag::query()->whereIn('id', $tagArray)->get('name')->pluck('name')->toArray();
                        $objects->withAllTags($tags);
                    }
                }
            }
        }

        if (isset($data['favorite'])) {
            $objects = $objects->whereFavorite((int)$data['favorite']);
        }

        $this->setIsSystem(false);
        $this->createActivity();

        if (isset($data['empty_trash'])) {
            $objects = $objects->onlyTrashed();

            $allObjects = $objects->get();

            foreach ($allObjects as $object) {

                $tags = $object->tags;

                Tag::reindex($tags, method: '-', deleteTag: true);

                $filePath = $object->path;
                $pathInfo = pathinfo($filePath);
                $fs = new Filesystem();

                $fs->delete($filePath);
                $fs->deleteDirectory($pathInfo['dirname']);

                $thumbs = env('PUBLIC_PATH') . DS . 'uploads' . DS . '*' . DS . '*' . DS . '*' . DS . '*';

                foreach ($fs->glob($thumbs . DS . $pathInfo['basename']) as $filename) {
                    $fs->delete($filename);
                }
            }

            foreach ($allObjects as $object) {
                Tagged::query()->where('taggable_id', $object->id)->where('taggable_type', StorageFile::class)->delete();
            }

            $objects->forceDelete();

            return $this->success('Корзина успешно удалена');
        } else {
            try {

                $allObjects = $objects->get();

                foreach ($allObjects as $object) {
                    $tags = $object->tags;
                    Tag::reindex($tags, method: '-');
                }

                $objects->delete();
            } catch (Exception $e) {
                if (env('APP_DEBUG_VARS') == true) {
                    debugvars($e->getMessage(), $e->getTrace());
                }
                return $this->error('Невозможно удалить обьекты');
            }
        }

        return $this->success('Обьекты удалены в корзину');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     * @api {POST} /api/storage/batch_delete_tags Мультиудаление тегов
     * @apiGroup Storage
     *
     * @apiParam {array} ids Массив тегов
     * @apiParam {string} token Ключ пользователя
     *
     */
    public function batchDeleteTags(Request $request)
    {
        $ids = $request->input('ids');

        if ($ids && $this->publicUser()) {
            $tagsToDelete = Tag::query()->whereIn('id', $ids);
            $selectedTags = $tagsToDelete->get();

            $this->setIsSystem(false);
            $this->setParams($selectedTags->toArray());
            $this->createActivity();

            foreach ($selectedTags as $tag) {
                $objects = TaggedModel::query()->where('tag_name', $tag->name)
                    ->where('tag_slug', $tag->slug)
                    ->where('taggable_type', StorageFile::class)->get();

                if ($tag->disabled == 1) {
                    continue;
                }

                foreach ($objects as $object) {
                    $o = StorageFile::query()->find($object->taggable_id);
                    if ($o) {
                        if (count($o->tags) == 1) {
                            $o->tag([__('No tag')]);
                        } else {
                            $o->untag($tag->name);
                        }
                    }
                }

                Tagged::query()->where('tag_name', $tag->name)->where('tag_slug', $tag->slug)->delete();

                $tag->forceDelete();
            }

        } else {
            return $this->error('Не задан массив тегов');
        }

        return $this->success();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {POST} /api/storage/multi_download Скачивание архива обьектов
     * @apiGroup Storage
     *
     * @apiParam {string} token Ключ пользователя
     * @apiParam {string} term Фильтр по ключевому слову
     * @apiParam {string} tags Фильтр по тегам через запятую
     * @apiParam {array} objectType Фильтр типу обьекта (contact, link, event, file, image, audio, video, archive)
     * @apiParam {boolean} favorite Фильтр по избранным (1 - да, 0 - нет)
     * @apiParam {array} ids Массив ids обьектов (не обязательно)
     */
    public function multiDownload(Request $request)
    {
        $data = $request->all();
        $objects = StorageFile::whereUserId($this->publicUser()->id);


        if (isset($data['ids']) && is_array($data['ids'])) {
            $objects = $objects->whereIn('id', $data['ids']);
        }

        if (isset($data['term'])) {
            $objects = $objects->where(function ($query) use ($data) {
                $query->orWhere('title', 'LIKE', '%' . $data['term'] . '%')
                    ->orWhere('description', 'LIKE', '%' . $data['term'] . '%')
                    ->orWhere('filename', 'LIKE', '%' . $data['term'] . '%')
                    ->orWhere('original_filename', 'LIKE', '%' . $data['term'] . '%')
                    ->orWhere('url', 'LIKE', '%' . $data['term'] . '%');
            });
        }

        if (isset($data['objectType']) && is_array($data['objectType'])) {
            $objects = $objects->whereIn('object_type', $data['objectType']);
        }

        if (isset($data['tags'])) {
            $tags = explode(',', $data['tags']);
            if (!empty($tags)) {
                $objects = $objects->tags()->whereIn('name', $tags);
            }
        }

        if (isset($data['favorite'])) {
            $objects = $objects->whereFavorite((int)$data['favorite']);
        }

        $objects = $objects->get();

        if (count($objects) > 0) {
            $zipname = rand(100, 2000) . date('YmdHis') . '.zip';
            $src = getenv('DOCUMENT_ROOT') . DS . 'uploads/zipped';
            $filePath = $src . DS . $zipname;

            $fs = new Filesystem();

            if (!file_exists($src)) {
                $fs->makeDirectory($src, 0755, true);
            }

            $zip = new ZipArchive();
            $zip->open($filePath, ZipArchive::CREATE);

            foreach ($objects as $object) {
                $filename = $object->original_filename;
                $zip->addFile($object->path, $filename);
            }

            $relativePath = DS . 'uploads/zipped' . DS . $zipname;

            return $this->success($relativePath);
        } else {
            return $this->error('Обьектов не найдено');
        }
    }

    /**
     * @param $zipName
     * @return ResponseFactory|Application|Response
     * @api {GET} /download_zip/{zipname} Архивация обьекта
     * @apiGroup Storage
     *
     * @apiParam {string} token Ключ пользователя
     *
     */
    public function downloadZip($zipName)
    {
        $filePath = sys_get_temp_dir() . DS . $zipName;

        if (file_exists($filePath)) {

            $this->setIsSystem(false);
            $this->setParams($filePath);
            $this->createActivity();

            return response()->download($filePath, null, [
                'Content-Type' => 'application/zip'
            ]);
        } else {
            return response('', 404);
        }
    }

    /**
     * @return JsonResponse
     * @api {GET} /api/storage/favorite Избранные Обьекты
     * @apiGroup Storage
     *
     * @apiParam {string} token Ключ пользователя
     *
     */
    public function favorite()
    {
        $files = StorageFile::query()->where(['user_id' => $this->publicUser()->id])->favorite()->get();

        if (count($files) == 0) {
            return $this->error('обьектов не найдено');
        }

        $this->setIsSystem(false);
        $this->setParams($files->toArray());
        $this->createActivity();

        return $this->success(['files' => $files]);
    }

    /**
     * @param Request $request
     * @return array
     * @api {GET} /api/storage/images/sort Сортировка картинок
     * @apiGroup Storage
     *
     * @apiParam {string} token Ключ пользователя
     * @apiParam {string} field Поле для сортировки (0 - title, 1 - created_at, 2 - size)
     * @apiParam {string} order Порядок сортировки (0 - ASC, 1 - DESC)
     * @apiParam {string} term Фильтр по имени или названию
     *
     */
    public function sort(Request $request)
    {
        return $this->images($request);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {GET} /api/storage/images список картинок
     * @apiGroup Storage
     *
     * @apiParam {string} token Ключ пользователя
     * @apiParam {string} field Поле для сортировки (0 - title, 1 - created_at, 2 - size)
     * @apiParam {string} order Порядок сортировки (0 - ASC, 1 - DESC)
     * @apiParam {string} term Фильтр по имени
     *
     */
    public function images(Request $request)
    {
        $images = StorageFile::query()->where('user_id', $this->publicUser()->id)->images();

        $field = $request->get('field', StorageFile::sort[1]);
        $order = $request->get('order', StorageFile::order[0]);
        $term = $request->get('term');
        $page = $request->get('page', 1);

        if (isset(StorageFile::sort[$field])) {
            $field = StorageFile::sort[$field];
        }

        if (isset(StorageFile::order[$order])) {
            $order = StorageFile::order[$order];
        }

        $images = $images->orderBy($field, $order);

        if ($term) {
            $images = $images->where('title', 'LIKE', '%' . $term . '%');
        }

        $images = $images->paginate(10, ['*']);
        $images = Utils::transformUrl($images);

        $images->appends([
            'field' => $field,
            'order' => $order,
            'term' => $term,
            'page' => $page
        ]);

        foreach ($images as &$image) {
            $image->makeHidden(['user', 'path']);
        }

        return $this->success(['images' => $images]);
    }

    /**
     * @return JsonResponse
     * @api {GET} /api/storage/files список обьектов
     * @apiGroup Storage
     *
     * @apiParam {string} token Ключ пользователя
     */
    public function files()
    {
        $files = StorageFile::query()->where('user_id', $this->publicUser()->id)->files()->get();

        return $this->success(['files' => $files]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     * @api {POST} /api/storage/combine_tags склейка тегов для обьектов
     * @apiGroup Storage
     *
     * @apiParam {string} token Ключ пользователя
     * @apiParam {string} tags строка тегов через запятую или массив
     * @apiParam {string} new_tag_name новое имя для тегов
     */
    public function combineTags(Request $request): JsonResponse
    {
        $selectedTags = $request->input('tags');
        $newTagName = $request->input('new_tag_name');
        $newTagName = trim(strip_tags($newTagName));

        $model = TaggingUtility::taggedModelString();

        if (!$newTagName) {
            return $this->error('Не задано имя нового тега');
        }

        $tagData = self::parseTags($selectedTags);

        if (empty($tagData)) {
            return $this->error('Не заданы теги');
        }

        /** @var Tagged $model */
        $allTags = $model::query()->distinct()->join('tagging_tags', 'tag_slug', '=', 'tagging_tags.slug')
            ->join('storage_file', 'storage_file.id', '=', 'tagging_tagged.taggable_id')
            ->where('taggable_type', '=', StorageFile::class)
            ->whereIn('tagging_tagged.tag_name', $tagData)
            ->where('storage_file.user_id', '=', $this->publicUser()->id)
            ->get(['taggable_id', 'taggable_type']);

        if (empty($allTags)) {
            return $this->error('Теги не найдены');
        }

        foreach ($allTags as $tag) {
            $object = StorageFile::query()->find($tag->taggable_id);
            if ($object) {
                $object->retag($newTagName);
            }
        }

        /** @var Tagged $model */
        $existantNewTag = $model::query()->distinct()->join('tagging_tags', 'tag_slug', '=', 'tagging_tags.slug')
            ->join('storage_file', 'storage_file.id', '=', 'tagging_tagged.taggable_id')
            ->where('taggable_type', '=', StorageFile::class)
            ->where('tagging_tagged.tag_name', $newTagName)
            ->where('storage_file.user_id', '=', $this->publicUser()->id)
            ->first();

        return $this->success($existantNewTag);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {POST} /api/storage/add_url Добавление урла в хранилище
     * @apiGroup Storage
     *
     * @apiParam {string} token Ключ пользователя
     * @apiParam {string} url URL
     * @apiParam {array} tags массив или строка тегов
     *
     */
    public function addUrl(Request $request): JsonResponse
    {
        $storageUrl = $request->input('url');
        $tags = $request->input('tags');
        $object = null;

        if ($storageUrl) {

            if (filter_var($storageUrl, FILTER_VALIDATE_DOMAIN)) {
                $hash = generate_code(16, true);
                $extension = current(array_keys(config('netgamer.scoped_link_types')));
                $docRoot = getenv('DOCUMENT_ROOT') . '/';
                $parsedUrl = parse_url($storageUrl);

                if (isset($parsedUrl['host'])) {
                    $urlName = $parsedUrl['host'];
                } else {
                    $urlName = $parsedUrl['path'];
                }

                $user = $this->publicUser();

                $path = StorageFile::STORAGE_PATH . $user->id . DS . $hash[0] . $hash[1] . DS .
                    $hash[2] . $hash[3] . DS . $hash[4] . DS . $extension . DS;

                $newFilename = $hash;

                $urlFile = view(theme('storage.url'), ['url' => $storageUrl])->render();

                File::makeDirectory($docRoot . $path, 0775, true);
                File::put($docRoot . $path . $newFilename . '.url', $urlFile);

                $filename = $docRoot . $path . $newFilename . '.url';

                $url = getSchema() . $user->domain . $path . $newFilename . '.url';

                $data = [
                    'user_id' => $user->id,
                    'filename' => $newFilename . '.url',
                    'type' => current(array_values(config('netgamer.scoped_link_types'))),
                    'size' => filesize($filename),
                    'hash' => $hash,
                    'extension' => $extension,
                    'url' => $url,
                    'path' => $docRoot . $path . '/' . $newFilename . '.url',
                    'object_type' => 'link',
                    'original_filename' => $urlName
                ];

                $object = StorageFile::create($data);

                if (!empty($tags)) {
                    $object->tag($tags);
                }

            } else {
                return $this->error('Невалидный URL или URL не найден');
            }
        } else {
            return $this->error('Введите URL');
        }

        $this->setIsSystem(false);
        $this->setParams($object->toArray());
        $this->createActivity();

        return $this->success(['object' => $object]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     * @api {POST} /api/storage/restore Восстановление обьекта/обьектов
     * @apiGroup Storage
     *
     * @apiParam {string} token Ключ пользователя
     * @apiParam {boolean} restore_all_from_trash Восстановление корзины
     * @apiParam {string} term Фильтр по ключевому слову
     * @apiParam {string} tags Фильтр по тегам через запятую
     * @apiParam {array} objectType Фильтр типу обьекта (contact, link, event, file, image, audio, video, archive)
     * @apiParam {boolean} favorite Фильтр по избранным (1 - да, 0 - нет)
     * @apiParam {array} ids Массив ids обьектов (не обязательно)
     *
     */
    public function restore(Request $request): JsonResponse
    {
        $data = $request->all();
        $objects = StorageFile::withTrashed()->byUser($this->publicUser()->id);

        if (isset($data['ids']) && is_array($data['ids'])) {

            $data['ids'] = array_map(function ($id) {
                return (int)$id;
            }, $data['ids']);

            $data['ids'] = array_filter($data['ids']);

            $objects = $objects->whereIn('id', $data['ids']);
        }

        if (isset($data['term'])) {

            $data['term'] = Utils::cleanChars($data['term']);

            $objects = $objects->where(function ($query) use ($data) {
                $query->orWhere('title', 'LIKE', '%' . $data['term'] . '%')
                    ->orWhere('description', 'LIKE', '%' . $data['term'] . '%')
                    ->orWhere('filename', 'LIKE', '%' . $data['term'] . '%')
                    ->orWhere('original_filename', 'LIKE', '%' . $data['term'] . '%')
                    ->orWhere('url', 'LIKE', '%' . $data['term'] . '%');
            });
        }

        if (isset($data['objectType']) && is_array($data['objectType'])) {
            $objects = $objects->whereIn('object_type', $data['objectType']);
        }

        if (isset($data['tags'])) {
            $tags = explode(',', $data['tags']);
            if (!empty($tags)) {
                $objects = $objects->withAllTags($tags);
            }
        }

        if (isset($data['favorite'])) {
            $objects = $objects->whereFavorite((int)$data['favorite']);
        }

        if (isset($data['restore_all_from_trash'])) {
            $objects = $objects->onlyTrashed();
        }

        if (count($objects->get()) == 0) {
            return $this->error('Обьекты не найдены');
        }

        $allObjects = $objects->get();

        foreach ($allObjects as $object) {

            $tags = $object->tags;

            Tag::reindex($tags);
        }

        $objects->restore();

        $this->setIsSystem(false);
        $this->createActivity();

        return $this->success();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {POST} /api/storage/unfavorite_file Удалить обьект из избранного
     * @apiGroup Storage
     *
     * @apiParam {string} token Ключ пользователя
     * @apiParam {integer} id ID обьекта
     *
     */
    public function unfavoriteFile(Request $request)
    {
        return $this->favoriteFile($request, false);
    }

    /**
     * @param Request $request
     * @param bool $favorite
     * @return JsonResponse
     * @api {POST} /api/storage/favorite_file Добавить обьект в избранное
     * @apiGroup Storage
     *
     * @apiParam {string} token Ключ пользователя
     * @apiParam {integer} id ID обьекта
     */
    public function favoriteFile(Request $request, bool $favorite = true): JsonResponse
    {

        $id = $request->input('id', null);
        $file = StorageFile::query()->where(['id' => $id, 'user_id' => $this->publicUser()->id])->first();

        if ($file) {
            $file->update([
                'favorite' => $favorite
            ]);
        } else {
            return $this->error('обьект не найден');
        }

        $favoriteCount = StorageFile::query()->where(['user_id' => $this->publicUser()->id])->favoriteCount();

        $data = [
            'favorite_count' => is_object($favoriteCount) ? 0 : $favoriteCount,
            'file' => $file->toArray()
        ];

        $this->setIsSystem(false);
        $this->setParams($data);
        $this->createActivity();

        return $this->success($data);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     * @api {POST} /api/storage/delete_tag Удаление тега из обьекта
     * @apiGroup Storage
     *
     * @apiParam {string} token Ключ пользователя
     * @apiParam {integer} id ID тега
     * @apiParam {integer} object_id ID обьекта
     *
     */
    public function deleteTag(Request $request): JsonResponse
    {
        $objectId = $request->input('object_id');
        $id = $request->input('id');

        $tag = StorageTag::find($id);
        $object = StorageFile::find($objectId);

        if ($this->publicUser() && $object && $object->user_id == $this->publicUser()->id && $tag) {
            $this->setIsSystem(false);
            $this->setParams($object->tags);
            $this->createActivity();

            $tag = Tag::query()->find($id);

            if (!$tag) {
                return $this->error('Тег не найден');
            }

            if ($tag->disabled == 1) {
                return $this->error('Этот тег удалить нельзя');
            }

            $object->untag($tag->name);
        }

        return $this->success();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {POST} /api/storage/update_tag Обновление имени тега
     * @apiGroup Storage
     *
     * @apiParam {string} token Ключ пользователя
     * @apiParam {string} name новое имя для тега
     * @apiParam {integer} id ID тега
     *
     */
    public function updateTag(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');

        $tag = Tag::query()->find($id);

        if (!$tag) {
            return $this->error('Тег не найден');
        }

        $exitingTag = Tag::query()->whereSlug(TaggingUtility::slug($name))->first();

        if ($exitingTag) {
            return $this->error('Такой новый тег уже есть');
        }

        $tag->update([
            'name' => $name,
            'slug' => TaggingUtility::slug($name)
        ]);

        $this->setIsSystem(false);
        $this->setParams($tag->toArray());
        $this->createActivity();

        return $this->success(['tag' => $tag]);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     * @api {POST} /api/storage/add_tag Добавление тега
     * @apiGroup Storage
     *
     * @apiParam {string} token Ключ пользователя
     * @apiParam {string} name Имя тега
     */
    public function addTag(Request $request): JsonResponse
    {
        $name = $request->get('name');

        if (!$name) {
            return $this->error('Не заданы все параметры');
        }

        $tag = Tag::query()->firstOrCreate([
            'name' => trim($name),
            'slug' => TaggingUtility::slug($name)
        ]);

        $tag = $tag->toArray();
        $tag['count'] = 0;

        $this->setIsSystem(false);
        $this->setParams($tag);
        $this->createActivity();

        return $this->success($tag);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {POST} /api/storage/add_tag_to_object Добавление тега к обьекту
     * @apiGroup Storage
     *
     * @apiParam {string} token Ключ пользователя
     * @apiParam {string} term Фильтр по ключевому слову
     * @apiParam {string} tags Фильтр по тегам через запятую
     * @apiParam {array} added_tags Новые теги
     * @apiParam {array} objectType Фильтр типу обьекта (contact, link, event, file, image, audio, video, archive)
     * @apiParam {boolean} favorite Фильтр по избранным (1 - да, 0 - нет)
     * @apiParam {boolean} add_to_all_objects Добавление тегов ко всем обьектам (true|false)
     * @apiParam {array} object_ids Массив ids обьектов (необязательно)
     */
    public function addTagToObject(Request $request)
    {
        $data = $request->all();

        if (empty($data['added_tags'])) {
            return $this->error('Не заданы новые метки');
        }

        $objects = StorageFile::withTrashed()->byUser($this->publicUser());

        if (isset($data['object_ids']) && is_array($data['object_ids'])) {

            $data['object_ids'] = array_map(function ($id) {
                return (int)$id;
            }, $data['object_ids']);

            $data['object_ids'] = array_filter($data['object_ids']);

            $objects = $objects->whereIn('id', $data['object_ids']);
        }

        if (isset($data['term'])) {

            $data['term'] = Utils::cleanChars($data['term']);

            $objects = $objects->where(function ($query) use ($data) {
                $query->orWhere('title', 'LIKE', '%' . $data['term'] . '%')
                    ->orWhere('description', 'LIKE', '%' . $data['term'] . '%')
                    ->orWhere('filename', 'LIKE', '%' . $data['term'] . '%')
                    ->orWhere('original_filename', 'LIKE', '%' . $data['term'] . '%')
                    ->orWhere('url', 'LIKE', '%' . $data['term'] . '%');
            });
        }

        if (isset($data['objectType']) && is_array($data['objectType'])) {
            $objects = $objects->whereIn('object_type', $data['objectType']);
        }

        if (isset($data['tags'])) {
            $tags = explode(',', $data['tags']);
            if (!empty($tags)) {
                $objects = $objects->withAllTags($tags);
            }
        }

        if (isset($data['favorite'])) {
            $objects = $objects->whereFavorite((int)$data['favorite']);
        }

        if (isset($data['restore_all_from_trash'])) {
            $objects = $objects->onlyTrashed();
        }

        $objects = $objects->get();

        if (count($objects) == 0) {
            return $this->error('Обьекты не найдены');
        }

        $addedTags = [];

        if (is_string($data['added_tags'])) {
            $addedTags = preg_split('/,/', $data['added_tags']);
        } elseif (is_array($data['added_tags'])) {
            $addedTags = $data['added_tags'];
        }

        $addedTags = array_map('trim', $addedTags);
        $addedTags = array_filter($addedTags);

        if (empty($addedTags)) {
            return $this->error('Не заданы новые метки');
        }

        $objects->map(function ($object) use ($addedTags) {
            $object->tag($addedTags);
        });

        $this->setIsSystem(false);
        $this->setParams($objects->toArray());
        $this->createActivity();

        return $this->success($objects);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {POST} /api/storage/add_multi_tag Добавление тегов через запятую
     * @apiGroup Storage
     *
     * @apiParam {string} token Ключ пользователя
     * @apiParam {string} tags Имя тегов через запятую
     *
     */
    public function addMultiTag(Request $request)
    {
        $tags = $request->get('tags');

        if (!isset($tags) || empty($tags)) {
            return $this->error('Не заданы теги');
        }

        $inputTags = TaggingUtility::makeTagArray($tags);

        if (!empty($inputTags)) {
            foreach ($inputTags as $inputTag) {
                Tag::firstOrCreate([
                    'slug' => TaggingUtility::slug($inputTag),
                    'name' => $inputTag
                ]);
            }
        } else {
            return $this->error('Не заданы теги');
        }

        $this->setIsSystem(false);
        $this->setParams($tags);
        $this->createActivity();

        return $this->success();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {POST} /api/storage/add_base64_files Добавление base64 обьектов
     * @apiGroup Storage
     *
     * @apiParam {string} token Ключ пользователя
     * @apiParam {string} files Массив обьектов в формате base64 или URL
     * (files[url => ..., title => ..., description => ...,])
     *
     */
    public function addBase64Files(Request $request): JsonResponse
    {
        $data = $request->all();

        if (empty($data['files'])) {
            return $this->error('Не задан массив обьектов');
        }

        $imagesData = [];
        $storageFile = null;
        $storageFileInstance = new StorageFile();

        foreach ($data['files'] as $index => $file) {

            $saveParams = [
                'title' => $file['title'],
                'description' => $file['description']
            ];
            if (is_array($file) && !empty($file['id'])) {
                $storageFile = StorageFile::updateById($file['id'], $saveParams);
            }

            if (is_array($file) && (isset($file['url']) && is_string($file['url'])
                    && strstr($file['url'], 'data:')) ||
                (isset($file['url_miniature']) && is_string($file['url_miniature']) &&
                    strstr($file['url_miniature'], 'data:'))) {

                $imagesData[$index] = $storageFileInstance->saveFile($file, $storageFile, $saveParams);

            } elseif (is_array($file) && isset($file['url']) && preg_match('/http/', $file['url'])) {
                $imagesData[$index] = $storageFileInstance->saveFromUrl($file, $saveParams);
            } else {
                if ($storageFile) {
                    $imagesData[$index] = $storageFile->thumbs;
                    $imagesData[$index]['id'] = $storageFile->id;
                    $imagesData[$index]['title'] = $storageFile->title;
                    $imagesData[$index]['description'] = $storageFile->description;
                    $imagesData[$index]['url'] = $storageFile->url . DS . $storageFile->filename;
                }
            }
        }

        $imagesData = array_filter($imagesData);

        if (empty($imagesData)) {
            return $this->error('Невозможно добавить изображения');
        }

        $this->setIsSystem(false);
        $this->createActivity();

        return $this->success($imagesData);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {POST} /api/storage/add_files Добавление обьектов с тегами
     * @apiGroup Storage
     *
     * @apiParam {string} token Ключ пользователя
     * @apiParam {string} files[] Массив обьектов
     * @apiParam {string} tags[] Теги для обьектов через запятую
     *
     */
    public function addFiles(Request $request): JsonResponse
    {
        $files = $request->file('files');
        $tags = $request->get('tags');
        $alldata = [];

        if (!empty($files)) {
            $user = $this->publicUser();

            foreach ($files as $file) {

                $error = $file->getError();

                if ($error == 0 && $file->isValid()) {
                    $hash = generate_code(16, true);
                    $extension = strtolower($file->getClientOriginalExtension());

                    $newFilename = $hash . '.' . $extension;

                    $path = StorageFile::STORAGE_PATH . $user->id . DS . $hash[0] . $hash[1] . DS .
                        $hash[2] . $hash[3] . DS . $hash[4] . DS . $extension . DS;

                    $url = getSchema() . $user->domain . $path;

                    $alldata[] = $data = [
                        'user_id' => $$user->id,
                        'filename' => pathinfo($file->getClientOriginalName())['filename'],
                        'type' => $file->getMimeType(),
                        'size' => $file->getSize(),
                        'hash' => $hash,
                        'extension' => $extension,
                        'url' => $url,
                        'path' => getenv('DOCUMENT_ROOT') . '/' . $path . $newFilename
                    ];

                    $newFile = StorageFile::query()->firstOrCreate($data);

                    $newFile->tag($tags);

                    $file->move(getenv('DOCUMENT_ROOT') . '/' . $path, $newFilename);
                } else {
                    return $this->error('Невалидный обьект');
                }
            }

        } else {
            return $this->error('Не заданы обьекты');
        }

        $this->setIsSystem(false);
        $this->setParams($alldata);
        $this->createActivity();

        return $this->success($alldata);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {POST} /api/storage/add_chunked_files Добавление обьектов (Chunked)
     * @apiGroup Storage
     *
     * @apiParam {string} token Ключ пользователя
     * @apiParam {string} type Тип обьекта
     * @apiParam {string} fileName Ключ пользователя
     * @apiParam {string} totalSize Ключ пользователя
     * @apiParam {blob} data Данные для чанка
     * @apiParam {integer} chunkPositionStart начало чанка
     * @apiParam {integer} chunkPositionEnd Конец чанка
     * @apiParam {string} uploadId
     * @apiParam {string} objectType тип обьекта ('contact', 'link', 'event', 'file', 'image', 'audio', 'video',
     * 'archive')
     * @apiParam {array} tags массив/строка тегов
     */
    public function addChunkedFiles(Request $request): JsonResponse
    {
        $uploadId = $request->get('uploadId');
        $fileName = $request->get('fileName');
        $totalSize = $request->get('totalSize');
        $type = $request->get('type');
        $data = $request->get('data');
        $chunkPositionStart = $request->get('chunkPositionStart');
        $chunkPositionEnd = $request->get('chunkPositionEnd');
        $user = $this->publicUser();

        $tags = $request->get('tags');

        $data = explode(',', $data);
        $data = $data[1];

        $objectType = $request->get('objectType');

        $validator = self::validateChunk($request->all());

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        $fileInfo = pathinfo($fileName);

        $extension = null;

        if (isset($fileInfo['extension'])) {
            $extension = $fileInfo['extension'];
        }

        $cleanChunk = $chunk = [
            'fileName' => $fileName,
            'time' => Carbon::now(),
            'data' => $data,
            'type' => $type,
            'totalSize' => $totalSize,
            'chunkPositionStart' => $chunkPositionStart,
            'chunkPositionEnd' => $chunkPositionEnd,
            'uploadId' => $uploadId
        ];

        $allData = [
                'uploaded' => 0,
                'file' => null
            ] + $cleanChunk;

        unset($allData['data']);
        unset($cleanChunk['data']);

        $key = 'Storage:' . $user->id . ':' . $uploadId;

        $uploadedChunk = Cache::get($key);
        $time = 60 * 24 * 180;

        if (!$uploadedChunk) {
            $uploadedChunk[] = $cleanChunk;
            Cache::put($key, $uploadedChunk, $time);
        } else {
            $uploadedChunk[] = $cleanChunk;
            Cache::put($key, $uploadedChunk, $time);
        }

        $wf = fopen('/tmp/c_' . $uploadId . '.' . count($uploadedChunk), 'wb');

        $blobData = base64_decode($data, true);

        fwrite($wf, $blobData);
        fclose($wf);

        $lastChunk = last($uploadedChunk);
        $disabled = 0;

        if ($lastChunk['totalSize'] == $cleanChunk['chunkPositionEnd']) {
            $uploadedChunk[] = $cleanChunk;

            if (empty($tags)) {
                $tags = [__('No tag')];
                $disabled = 1;
            }

            $allData = self::saveChunkedFile($uploadId, $extension, $totalSize, $objectType,
                $fileName, $cleanChunk, $tags);

            $tag = $allData['object']->tags[0];

            if ($disabled == 1) {
                $tag->update([
                    'disabled' => 1
                ]);
            }

            $this->success($allData);
        }

        return $this->success($allData);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ImagickException
     * @internal param bool $asJson
     * @api {POST} /api/storage/add_images Добавление массива картинок в хранилище
     * @apiGroup Storage
     *
     * @apiParam {string} token Ключ пользователя
     * @apiParam {string} files[] Массив обьектов
     * @apiParam {string} content_type (article, section)
     */
    public function addImages(Request $request)
    {
        $requestData = $request->all();
        $contentTypes = implode(',', StorageFile::CONTENT_TYPES);

        $validator = Validator::make($requestData, [
            'files' => 'array|required',
            'content_type' => 'required|in:' . $contentTypes
        ], [
            'files.array' => 'Это не массив',
            'files.required' => 'Не заданы обьекты',
            'content_type.in' => 'Неверный тип контента: ' . $contentTypes,
            'content_type.required' => 'Не задан тип контента'
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }
        $images = [];

        /** @var UploadedFile $file */
        foreach ($requestData['files'] as $file) {
            $request->request->add(['file' => $file]);
            $images[] = $this->addImage($request, null);
        }

        $this->setIsSystem(false);
        $this->setParams($images);
        $this->createActivity();

        return $this->success($images);
    }

    /**
     * @param Request $request
     * @param bool $asJson
     * @return false|JsonResponse|string
     * @throws ImagickException
     * @api {POST} /api/storage/add_image Добавление картинки в хранилище
     * @apiGroup Storage
     *
     * @apiParam {string} token Ключ пользователя
     * @apiParam {string} file обьект
     * @apiParam {string} content_type (article, section)
     *
     */
    public function addImage(Request $request, $asJson = true)
    {
        $requestData = $request->all();
        $contentTypes = implode(',', StorageFile::CONTENT_TYPES);

        $validator = Validator::make($requestData, [
            'file' => 'required',
            'content_type' => 'required|in:' . $contentTypes
        ], [
            'file.required' => 'Не задан обьект',
            'content_type.in' => 'Неверный тип контента: ' . $contentTypes,
            'content_type.required' => 'Не задан тип контента'
        ]);

        if ($validator->fails()) {
            if ($asJson == true) {
                return $this->error($validator->errors());
            } else {
                return $validator->errors()->toArray();
            }
        }

        /** @var UploadedFile $file */
        $file = $requestData['file'];
        $error = $file->getError();

        if ($error > 0 && $file->isValid()) {
            if ($asJson == true) {
                return $this->error($validator->errors());
            } else {
                return [
                    'result' => 'error',
                    'message' => $file->getErrorMessage()
                ];
            }
        }

        $extension = $file->guessClientExtension();

        if (empty($extension)) {
            $extension = 'png';
        }

        $hash = generate_code(16, true);

        $user = $this->publicUser();

        $path = StorageFile::STORAGE_PATH . $user->id . DS . $hash[0] . $hash[1] . DS .
            $hash[2] . $hash[3] . DS . $hash[4] . DS . $extension . DS;

        $fs = new Filesystem();
        $fs->makeDirectory(getenv('DOCUMENT_ROOT') . DS . $path, 0777, true);
        $imageName = pathinfo($file->getClientOriginalName());

        $newFilename = $hash . '.' . $extension;

        $serverFullPath = getenv('DOCUMENT_ROOT') . DS . $path . DS . $newFilename;

        file_put_contents($serverFullPath, file_get_contents($file->getRealPath()));

        $fullPath = getenv('DOCUMENT_ROOT') . DS . $path . $newFilename;

        $url = getSchema() . $user->domain . $path;

        $data = [
            'user_id' => $user->id,
            'filename' => $imageName['filename'],
            'type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'hash' => $hash,
            'extension' => $extension,
            'url' => $url,
            'path' => $fullPath
        ];

        StorageFile::create($data);

        $thumbs = $this->createStorageThumbs($fullPath);

        $data['thumbs'] = $thumbs;

        $this->setIsSystem(false);
        $this->setParams($data);
        $this->createActivity();

        if ($asJson == true) {
            return $this->success($data);
        } else {
            return $data;
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ImagickException
     * @throws GuzzleException
     * @api {POST} /api/storage/get_image_from_url Добавление добавление картинки через URL
     * @apiGroup Storage
     *
     * @apiParam {string} token Ключ пользователя
     * @apiParam {string} URL URL на картинку со стороннего ресурса
     */
    public function getImageFromUrl(Request $request)
    {
        $requestData = $request->all();

        $contentTypes = implode(',', StorageFile::CONTENT_TYPES);

        $validator = Validator::make($requestData, [
            'url' => 'required|url|active_url',
            'content_type' => 'required|in:' . $contentTypes,
        ], [
            'url.required' => 'Не задан URL',
            'url.url' => 'Это не URL',
            'url.active_url' => 'Этот URL неактивный',
            'content_type.required' => 'Не задан тип контента (статья, раздел)',
            'content_type.in' => 'Неверный тип контента: ' . $contentTypes
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        $image = basename($requestData['url']);
        $imageName = pathinfo($image);

        $extension = !empty($imageName['extension']) ? $imageName['extension'] : 'jpg';

        if (!in_array($extension, array_keys(config('netgamer.scoped_image_types')))) {
            return $this->error('Невалидный обьект');
        } else {
            $stream = new Streamable();
            $stream->setPath($requestData['url']);

            $fInfo = new finfo(FILEINFO_MIME);
            $mime = $fInfo->file($stream->getStreamPath(), FILEINFO_MIME_TYPE, $stream->getContext());

            if (!in_array($mime, array_values(config('netgamer.scoped_image_types')))) {
                return $this->error('Невалидный mime тип обьекта');
            } else {

                $mimeTypes = array_flip(config('netgamer.scoped_image_types'));
                $hash = generate_code(16, true);

                $extension = $mimeTypes[$mime];

                $newFilename = $hash . '.' . $extension;

                $user = $this->publicUser();

                $path = StorageFile::STORAGE_PATH . $user->id . DS . $hash[0] . $hash[1] . DS .
                    $hash[2] . $hash[3] . DS . $hash[4] . DS . $extension . DS;

                $fs = new Filesystem();
                $fs->makeDirectory(getenv('DOCUMENT_ROOT') . DS . $path, 0777, true);

                $guzzle = new Client();
                $result = $guzzle->request('GET', $requestData['url']);

                $serverFullPath = getenv('DOCUMENT_ROOT') . DS . $path . DS . $newFilename;

                file_put_contents($serverFullPath, $result->getBody());

                $fullPath = getenv('DOCUMENT_ROOT') . DS . $path . $newFilename;

                $url = getSchema() . $user->domain . $path;

                $data = [
                    'user_id' => $user->id,
                    'filename' => $imageName['filename'],
                    'type' => $mime,
                    'size' => $result->getHeaderLine('Content-Length'),
                    'hash' => $hash,
                    'extension' => $extension,
                    'url' => $url,
                    'path' => $fullPath
                ];

                StorageFile::query()->firstOrCreate($data);

                $thumbs = $this->createStorageThumbs($fullPath);

                $data['thumbs'] = $thumbs;

                return $this->success($data);
            }
        }
    }

    /**
     * @param Request $request
     * @param null $recycled
     * @return JsonResponse
     * @api {GET} /api/storage/tag_tree Дерево тегов
     * @apiGroup Storage
     * @apiParam {string} token Ключ пользователя
     * @apiParam {integer} field Поле для сортировки (0 - title, 1 - created_at, 2 - size, 3 - original_filename, 4 -
     * favorite, 5 - id)
     * @apiParam {integer} order Порядок сортировки (0 - DESC, 1 - ASC)
     * @apiParam {string} term Фильтр по ключевому слову
     * @apiParam {string} tags Фильтр тегов (string, json, array)
     * @apiParam {array} objectType Фильтр типу обьекта (contact, link, event, file, image, audio, video, archive)
     * @apiParam {boolean} favorite Фильтр по избранным (1 - да, 0 - нет)
     * @apiParam {boolean} without_tags Обьекты без тегов (1 - да)
     */
    public function tagTree(Request $request, $recycled = null): JsonResponse
    {
        $data = $request->all();
        $allTagArray = [];

        $allTags = Tag::relatedTags(StorageFile::class);

        $files = TaggingUtility::taggedModelString()::query()->distinct()
            ->join('storage_file', 'storage_file.id', '=', 'tagging_tagged.taggable_id')
            ->where('taggable_type', '=', StorageFile::class)
            ->where('storage_file.user_id', '=', $this->publicUser()->id)
            ->groupBy('storage_file.id')->get();

        $filesCount = $files->count();

        $totalSize = $files->map(function ($file) {
            return $file->size;
        })->sum();

        if (isset($data['tags']) && !empty($data['tags'])) {

            $tagData = self::parseTags($data['tags']);

            if (!empty($tagData)) {
                foreach ($allTags as $j => $allTag) {
                    $allTagArray[$j] = $allTag->toArray();
                    $allTagArray[$j]['children'] = [];
                    foreach ($tagData as $i => $tagDatum) {
                        if ($allTagArray[$j]['id'] == $tagDatum[0]) {
                            $tags = Tag::query()->whereIn('id', $tagDatum)->get()->pluck('name')->toArray();

                            $objects = self::makeQuery($data, $recycled);
                            $objects = $objects->withAllTags($tags)->get();
                            foreach ($objects as $object) {
                                foreach ($object->tags as $tag) {
                                    if ($tag->name != $allTag->name) {
                                        $allTagArray[$j]['children'][$tag->id] = $tag->toArray();
                                    }
                                }
                            }
                            if (!empty($allTagArray[$j]['children'])) {
                                $allTagArray[$j]['children'] = collect($allTagArray[$j]['children'])
                                    ->sortBy('name')->values();
                            }
                        }
                    }
                }
            }
        } else {
            $allTagArray = $allTags;
        }

        return $this->success([
            'tags' => $allTagArray,
            'total_size' => $totalSize,
            'files_count' => $filesCount
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {GET} /api/storage/tags Список тегов
     * @apiGroup Storage
     * @apiParam {array} tags Фильтр тегов (string, json, array)
     * @apiParam {string} recycled Удаленные файлы с тегами (1- с удаленными, без параметра- без удаленных файлов)
     * @apiParam {string} token Ключ пользователя
     */
    public function tags(Request $request): JsonResponse
    {
        $data = $request->all();
        $allTags = collect();
        $filesCount = 0;
        $totalSize = 0;
        $totalSpace = get_site()?->domainVolume?->size;
        $user = Auth::user();

        if (!$user->hasPermission('storage_access')) {
            return $this->error('У вас нет прав для входа в хранилище');
        }

        if (isset($data['tags']) && !empty($data['tags'])) {

            $tagData = self::parseTags($data['tags']);

            if (!empty($tagData)) {

                foreach ($tagData as $tagArray) {
                    if (is_array($tagArray)) {
                        $tags = Tag::query()->whereIn('id', $tagArray)->get('name')->pluck('name')->toArray();
                        $scopedFiles = StorageFile::query();

                        if (isset($data['recycled'])) {
                            $scopedFiles = $scopedFiles->whereNotNull('deleted_at');
                        }

                        $scopedFiles = $scopedFiles->withAllTags($tags)->get();

                        foreach ($scopedFiles as $file) {
                            if (count($file->tags) > 0) {
                                foreach ($file->tags as $tag) {

                                    if (!in_array($tag->name, $tags)) {
                                        $merged = array_merge($tags, [$tag->name]);

                                        $tagFiles = StorageFile::query();

                                        if (isset($data['recycled'])) {
                                            $tagFiles = $tagFiles->whereNotNull('deleted_at');
                                        } else {
                                            $tagFiles = $tagFiles->whereNull('deleted_at');
                                        }

                                        $tagFiles = $tagFiles->withAllTags($merged)->get();

                                        $countTagFiles = count($tagFiles);
                                        if ($countTagFiles > 0) {
                                            $left = $tag->only(['id', 'name', 'count']);
                                            $right = ['count' => $countTagFiles];
                                            $filesCount += $countTagFiles;
                                            $allTags[$tag->id] = array_merge($left, $right);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            $allTags = $allTags->values();

        } else {

            $allTags = Tag::relatedTags(StorageFile::class);

            $files = TaggingUtility::taggedModelString()::query()->distinct()
                ->join('storage_file', 'storage_file.id', '=', 'tagging_tagged.taggable_id');

            if (isset($data['recycled'])) {
                $files = $files->whereNotNull('storage_file.deleted_at');
            } else {
                $files = $files->whereNull('storage_file.deleted_at');
            }

            $files = $files->where('taggable_type', '=', StorageFile::class)
                ->where('storage_file.user_id', '=', $this->publicUser()->id)
                ->groupBy('storage_file.id')->get();

            $filesCount = $files->count();

            $totalSize = $files->map(function ($file) {
                return $file->size;
            })->sum();
        }

        return $this->success([
            'tags' => $allTags,
            'total_tags' => $allTags->count(),
            'total_files' => $filesCount,
            'total_size' => format_bytes($totalSize),
            'total_space' => format_bytes($totalSpace * pow(1024, 3))
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {GET} /api/storage/totals ИНформация о хранилище
     * @apiGroup Storage
     * @apiParam {string} recycled Удаленные файлы с тегами (1- с удаленными, без параметра- без удаленных файлов)
     * @apiParam {string} token Ключ пользователя
     */
    public function totals(Request $request): JsonResponse
    {
        $data = $request->all();
        $allTags = collect();
        $filesCount = 0;
        $totalSize = 0;
        $totalSpace = get_site()?->domainVolume?->size;

        /**
         * @todo duplicated code
         */
        if (isset($data['tags']) && !empty($data['tags'])) {

            $tagData = self::parseTags($data['tags']);

            if (!empty($tagData)) {

                foreach ($tagData as $tagArray) {
                    if (is_array($tagArray)) {
                        $tags = Tag::query()->whereIn('id', $tagArray)->get('name')->pluck('name')->toArray();
                        $scopedFiles = StorageFile::query();

                        if (isset($data['recycled'])) {
                            $scopedFiles = $scopedFiles->whereNotNull('deleted_at');
                        }

                        $scopedFiles = $scopedFiles->withAllTags($tags)->get();

                        foreach ($scopedFiles as $file) {
                            if (count($file->tags) > 0) {
                                foreach ($file->tags as $tag) {

                                    if (!in_array($tag->name, $tags)) {
                                        $merged = array_merge($tags, [$tag->name]);

                                        $tagFiles = StorageFile::query();

                                        if (isset($data['recycled'])) {
                                            $tagFiles = $tagFiles->whereNotNull('deleted_at');
                                        } else {
                                            $tagFiles = $tagFiles->whereNull('deleted_at');
                                        }

                                        $tagFiles = $tagFiles->withAllTags($merged)->get();

                                        $countTagFiles = count($tagFiles);
                                        if ($countTagFiles > 0) {
                                            $left = $tag->only(['id', 'name', 'count']);
                                            $right = ['count' => $countTagFiles];
                                            $filesCount += $countTagFiles;
                                            $allTags[$tag->id] = array_merge($left, $right);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            $allTags = array_values($allTags->toArray());

        } else {
            $model = TaggingUtility::taggedModelString();

            /**
             * @todo duplicated code
             */
            $allTags = $model::query()->distinct()->join('tagging_tags', 'tag_slug', '=', 'tagging_tags.slug')
                ->join('storage_file', 'storage_file.id', '=', 'tagging_tagged.taggable_id')
                ->whereNull('storage_file.deleted_at')
                ->where('taggable_type', '=', StorageFile::class)
                ->where('storage_file.user_id', '=', Auth::user()->id)
                ->orderBy('tag_slug', 'ASC')
                ->whereNull('tagging_tags.deleted_at')
                ->get(['tagging_tags.id', 'tag_name as name', 'tagging_tags.count as count']);

            $files = $model::query()->distinct()
                ->join('storage_file', 'storage_file.id', '=', 'tagging_tagged.taggable_id')
                ->whereNull('storage_file.deleted_at')
                ->where('taggable_type', '=', StorageFile::class)
                ->where('storage_file.user_id', '=', Auth::user()->id)
                ->groupBy('storage_file.id')->get();

            $filesCount = $files->count();

            $totalSize = $files->map(function ($file) {
                return $file->size;
            })->sum();
        }

        return $this->success([
            'total_tags' => $allTags->count(),
            'total_files' => $filesCount,
            'total_size' => format_bytes($totalSize),
            'total_space' => format_bytes($totalSpace * pow(1024, 3))
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {GET} /api/storage/search_tag Поиск по тегам
     * @apiGroup Storage
     * @apiParam {integer} field Поле для сортировки (0 - title, 1 - created_at, 2 - size, 3 - original_filename, 4 -
     * favorite, 5 - id)
     * @apiParam {integer} order Порядок сортировки (0 - DESC, 1 - ASC)
     * @apiParam {string} token Ключ пользователя
     * @apiParam {string} term Ключевое слово
     */
    public function searchTag(Request $request): JsonResponse
    {
        $term = $request->get('term');

        if (!$term) {
            return $this->error('Не задано ключевое слово');
        }

        $model = TaggingUtility::taggedModelString();

        $tags = $model::query()->distinct()->join('tagging_tags', 'tag_slug', '=', 'tagging_tags.slug')
            ->join('storage_file', 'storage_file.id', '=', 'tagging_tagged.taggable_id')
            ->where('taggable_type', StorageFile::class)
            ->where('storage_file.user_id', $this->publicUser()->id)
            ->orderBy('tag_slug', 'ASC')
            ->whereNull('tagging_tags.deleted_at')
            ->where(function ($query) use ($term) {
                $query->orWhere('tag_slug', 'like', '%' . $term . '%')
                    ->orWhere('tag_name', 'like', '%' . $term . '%');
            })
            ->limit(10)
            ->get(['tagging_tags.id', 'tag_name as name', 'tagging_tags.count as count']);

        return $this->success($tags);
    }

    /**
     * @param $id
     * @return JsonResponse
     * @api {GET} /api/storage/download/{id} Скачать обьект
     * @apiGroup Storage
     *
     * @apiParam {string} token Ключ пользователя
     *
     */
    public function download($id): JsonResponse
    {
        $user = $this->publicUser();

        $domain = getSchema() . $user->domain;

        $file = StorageFile::query()->byUser($user->id)->find($id);

        if (!$file || !file_exists($file->path)) {
            return $this->error('файл не найден');
        }

        $this->setIsSystem(false);
        $this->setParams($file->toArray());
        $this->createActivity();

        return $this->success($domain . $file->url);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {GET} /api/storage/search Поиск обьектов по тегам/именам
     * @apiGroup Storage
     *
     * @apiParam {string} token Ключ пользователя
     * @apiParam {string} term ключевое слово
     *
     * @internal param $id
     */
    public function search(Request $request): JsonResponse
    {
        $term = $request->get('term');
        $files = [];

        if ($term) {
            $term = trim($term);

            if (mb_strlen($term) < 3) {
                return $this->error('Строка для поиска должна содержать не менее 3 символов');
            }

            $searchFiles = StorageFile::query()->where('user_id', $this->publicUser()->id)
                ->where(function ($query) use ($term) {
                    $query->orWhere('title', 'LIKE', '%' . $term . '%')
                        ->orWhere('description', 'LIKE', '%' . $term . '%')
                        ->orWhere('filename', 'LIKE', '%' . $term . '%')
                        ->orWhere('original_filename', 'LIKE', '%' . $term . '%')
                        ->orWhere('url', 'LIKE', '%' . $term . '%');
                })->get();

            if (count($searchFiles) > 0) {
                foreach ($searchFiles as $searchFile) {
                    $files[] = $searchFile;
                }
            }
        } else {
            return $this->error('Не задана строка для поиска');
        }

        return $this->success(compact('files'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function validateUrlImage(Request $request): JsonResponse
    {
        $url = $request->get('url');
        $image = false;
        $error = 'Неверный URL';

        if (!$url) {
            return $this->error($error);
        }

        $extension = pathinfo($url, PATHINFO_EXTENSION);

        if (empty($extension)) {
            return $this->error($error);
        }

        if (!in_array($extension, array_keys(config('netgamer.scoped_image_types')))) {
            return $this->error($error);
        } else {

            $filename = generate_code(16, true);
            $filePath = DS . sys_get_temp_dir() . DS . $filename . '.' . $extension;

            Curl::to($url)
                ->withContentType('image/' . $extension)
                ->download($filePath);

            if (@is_array(getimagesize($filePath))) {
                $image = true;
            }
        }

        if ($image) {
            return $this->success(compact('url'), 'URL валидный');
        } else {
            return $this->error($error);
        }

    }
}
