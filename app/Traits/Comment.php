<?php

namespace App\Traits;

use App\Models\Comment as CommentModel;
use App\Models\Complain;
use App\Models\Modules\ModuleComment;
use App\Models\Modules\ModuleSettings;
use App\Models\Site;
use Auth;
use Carbon\Carbon;
use DOMDocument;
use File;
use Illuminate\Http\JsonResponse;
use JetBrains\PhpStorm\ArrayShape;
use Validator;

trait Comment
{
    use Announceable;

    public static function createModuleCommentValidator($data, $except = [], $customErrors = [])
    {
        $default = [
            'view' => 'required|in:' . implode(',', ModuleComment::mapConstants(ModuleComment::$view)),
            'sort_by' => 'required|in:' . implode(',', ModuleComment::mapConstants(ModuleComment::$sortBy)),
            'module_settings_id' => 'required',
            'sort_order' => 'required|in:' . implode(',', ModuleComment::mapConstants(ModuleComment::$sortOrder)),
            'position' => 'required|in:' . implode(',', array_keys(ModuleSettings::$positionOptions)),
            'name' => 'required',
            'block_cell_id' => 'required',
            'block_type_id' => 'required'
        ];

        $messages = [
            'view.required' => 'Не задан вид блока',
            'sort_by.required' => 'Не задана сортировка',
            'sort_by.in' => 'Неверная сортировка',
            'sort_order.required' => 'Не задан порядок сортировки',
            'sort_order.in' => 'Неверный порядок сортировки',
            'module_settings_id.required' => 'Не задан ID настроек',
            'name.required' => 'Заполните название блока статей',
            'block_cell_id' => 'Не задан ID ячейки блока',
            'block_type_id' => 'Не задан тип блока для ячейки'
        ];

        return Utils::makeValidator($data, $messages, [], $default, $customErrors, $except);
    }

    public function addComment($request, $commentModel, $articleModel, $siteModel = Site::class)
    {
        $comment = null;
        $glued = false;

        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'content' => 'required|min:3',
            'o_id' => 'required'
        ], [
            'content.required' => 'Напишите сообщение...',
            'o_id.required' => 'Не задан ID обьекта'
        ]);

        if (!$user) {
            return $this->error('Вам нужно войти, чтоб добавить комментарий...');
        }

        if (!$user->can('comment_create', CommentModel::class)) {
            return $this->error('У Вас нет прав для создания комментария');
        }

        $site = $this->getSite(env('DOMAIN'), $siteModel);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        $content = preg_replace("/\s+/", " ", $request->get('content'));
        $content = strip_tags($content);

        if (mb_strlen($content) >= 0 && mb_strlen($content) < 3) {
            return $this->error('Комментарий должен быть не менее 3 символов');
        }

        $objectId = $request->get('o_id');
        $parentId = $request->get('parent_id', null);
        $object = $request->get('o', $articleModel);

        $reactData = $request->get('react_data', null);

        $objectData = app($object)::bySite($site->id)->find($objectId);

        if (!$objectData) {
            return $this->error('Обьект не найден');
        }

        $allowComments = isset($objectData->settings['allow_comments']) ?
            (int)$objectData->settings['allow_comments'] : 0;

        $status = $commentModel::STATUS_APPROVED;

        $moderated = 1;

        if (!empty($objectData) && !$validator->fails()) {

            if ($allowComments == 1) {

                $moderateComments = isset($objectData->settings['moderate_comments']) ?
                    (int)$objectData->settings['moderate_comments'] : 0;

                if ($moderateComments == 0) {
                    $moderated = 1;
                    $status = $commentModel::STATUS_APPROVED;
                }

                if ($moderateComments == 1) {
                    if ((int)($objectData->author_id == $user->id)) {
                        $moderated = 1;
                        $status = $commentModel::STATUS_APPROVED;
                    } else {
                        $moderated = 0;
                        $status = $commentModel::STATUS_ON_MODERATION;
                    }
                }

                $data = [
                    'object_id' => $objectId,
                    'author_id' => $user->id,
                    'content' => $this->parseContent($objectId, $content),
                    'object' => $object,
                    'parent_id' => $parentId,
                    'moderated' => $moderated,
                    'moderator_id' => ($moderated == 1) ? $user->id : null,
                    'status' => $status,
                    'site_id' => $site->id,
                    'react_data' => $reactData,
                ];

                $lastComment = $commentModel::whereObjectId($objectId)
                    ->where('object', $object)->orderBy('id', 'desc')->first();

                $minuteDifference = false;

                if ($lastComment && $lastComment->author_id == $user->id) {
                    $minuteDifference = minute_difference(date('Y-m-d H:i:s', time()), $lastComment->created_at)
                        <= config('netgamer.comments.glued');
                }

                if ($lastComment) {
                    $updateData = [
                        'content' => $lastComment->content . $data['content'],
                        'parent_id' => $parentId,
                        'react_data' => $this->reactDataComment($lastComment->react_data, $reactData),
                    ];
                }

                if ($status != $commentModel::STATUS_ON_MODERATION) {
                    if ($minuteDifference == true) {
                        $lastComment->update($updateData);
                        $glued = true;
                        $comment = $lastComment;
                    } else {
                        $comment = $commentModel::firstOrCreate($data);
                    }
                } else {
                    if ($minuteDifference == true) {
                        if ($lastComment->status == $commentModel::STATUS_ON_MODERATION) {
                            $lastComment->update($updateData);
                            $glued = true;
                            $comment = $lastComment;
                        } else {
                            $comment = $commentModel::firstOrCreate($data);
                        }
                    } else {
                        $comment = $commentModel::firstOrCreate($data);
                    }
                }

                Announceable::setAnnounceFromContent($content, $comment, $site);

                $data = compact('comment', 'user', 'glued');
                $data['object'] = $objectData;

                if ($glued == false && $objectData->author) {
                    activity(
                        $objectData->author,
                        $user,
                        ['o' => $articleModel, 'o_id' => $objectData->id],
                        ['from_o' => $commentModel, 'from_o_id' => $comment->id],
                        null, null, ['comment' => $objectData],
                        $request,
                        1, 0
                    );
                }

                if ($parentId && $comment->parent && $comment->parent->author) {
                    activity(
                        $comment->parent->author,
                        $user,
                        ['o' => $commentModel, 'o_id' => $comment->parent_id],
                        ['from_o' => $commentModel, 'from_o_id' => $comment->id], null, null, ['comment' => $comment],
                        $request, 1, 0
                    );
                }

            } else {
                return $this->error('Нельзя добавить комментарий к этой статье...');
            }

            if ($status == $commentModel::STATUS_ON_MODERATION) {
                return $this->error('Комментарий будет добавлен после модерации...');
            }

            $commentsTotal = $commentModel::where([
                'object_id' => $objectData->id,
                'object' => $articleModel,
                'status' => $commentModel::STATUS_APPROVED])->count('id');

            $objectData->update([
                'last_comment_id' => $comment->id,
                'last_comment_at' => $comment->created_at,
                'last_comment_author' => username($comment->author),
                'comments_cnt' => $commentsTotal
            ]);

            if ($objectData->section) {
                $objectData->section->update([
                    'last_comment_id' => $comment->id,
                    'last_comment_date' => Carbon::now()->toDateTimeString()
                ]);

                if ($glued == false) {
                    $objectData->section->increment('comments_cnt');
                }
            }
        }

        return $this->success([
            'comment' => $comment, 'glued' => $glued
        ]);
    }

    /**
     * @param $objectId
     * @param null $content
     * @return string
     */
    private function parseContent($objectId, $content = null)
    {
        $document = new DOMDocument('1.0');
        $document->loadHTML('<?xml encoding="utf-8" />' . $content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images = $document->getElementsByTagName('img');

        if ($images->length > 0) {
            $this->parseImages($images, $objectId);
        }

        return htmlspecialchars($document->saveHTML(), ENT_COMPAT, 'UTF-8');
    }

    /**
     * @param $images
     * @param $objectId
     */
    private function parseImages($images, $objectId)
    {
        foreach ($images as $image) {
            $imageBase64 = $image->getAttribute('src');
            $imageArray = preg_split('/[\:|\;|,]/', $imageBase64);

            if (!empty($imageArray) && count($imageArray) >= 3) {
                $mime = $imageArray[1];
                $imageData = $imageArray[3];
                $imageMd5Name = md5($imageData) . round(microtime(true) * 1000);
                $imageFolder = substr($imageMd5Name, 0, 3);
                $mimeTypes = array_flip(config('netgamer.scoped_image_types'));

                if (isset($mimeTypes[$mime])) {
                    $imageFullFolder = '/uploads/storage/comments/' . $objectId . '/' . Auth::user()->id . '/' . $imageFolder;

                    if (!file_exists(getenv('DOCUMENT_ROOT') . $imageFullFolder)) {
                        File::makeDirectory(getenv('DOCUMENT_ROOT') . $imageFullFolder, 0775, true);
                    }

                    $imageName = $imageFullFolder . '/' . $imageMd5Name . '.' . $mimeTypes[$mime];

                    /**
                     * /uploads/comments/OBJECT_ID/USER_ID/IMAGE_FOLDER_FROM_NAME/IMAGE.XXX
                     */
                    file_put_contents(getenv('DOCUMENT_ROOT') . $imageName, base64_decode($imageData));

                    $image->setAttribute('src', $imageName);
                }
            }
        }
    }

    public function reactDataComment($comment, $newComment)
    {
        $comment = json_decode($comment, true);
        $newComment = json_decode($newComment, true);
        if ($newComment) {
            foreach ($newComment["blocks"] as $key => $value) {

                if (count($value["entityRanges"]) == 0) {
                    array_push($comment["blocks"], $value);
                } else {
                    $newBlock = $value;
                    foreach ($value["entityRanges"] as $keyEntity => $valueEntity) {

                        array_push($comment["entityMap"], $newComment["entityMap"][$valueEntity["key"]]);
                        end($comment["entityMap"]);
                        $lastKeyEntity = key($comment["entityMap"]);
                        $newBlock["entityRanges"][$keyEntity]["key"] = $lastKeyEntity;

                    }
                    array_push($comment["blocks"], $newBlock);
                }
            }
        }
        return json_encode($comment, JSON_UNESCAPED_UNICODE);
    }

    public function editComment($request, $commentModel)
    {
        $comment = null;

        $data = $request->all();
        $user = Auth::user();

        $validator = Validator::make($data, [
            'id' => 'required'
        ], [
            'id.required' => 'Не задан параметр ID'
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        if ($user) {
            $id = $data['id'];
            $comment = $commentModel::find($id);

            if (!$comment) {
                return $this->error('Комментарий не найден');
            }

            if (!$user->can('comment_edit', $comment)) {
                return $this->error('У вас нет прав для редактирования комментария');
            }
        } else {
            $this->error('Вам нужно войти, чтоб добавить комментарий...');
        }

        return $this->success(['comment' => $comment]);
    }

    public function commentsIndex($request, $articleModel, $commentModel, $commentArchiveModel)
    {
        $data = $request->all();
        $objectId = isset($data['o_id']) ? $data['o_id'] : null;
        $o = isset($data['o']) ? $data['o'] : null;

        $comments = [];

        if (!$objectId) {
            return $this->error('Неверный параметр o_id');
        }

        if (!$o) {
            return $this->error('Неверный параметр o');
        }

        if (class_exists($o)) {

            $object = app($o)::find($objectId);

            if (!$object) {
                return $this->error('Коментариев не найдено...');
            }

            if (isset($object->settings['allow_comments']) && (int)$object->settings['allow_comments'] == 1) {
                $comments = $this->loadComments($object, $articleModel, $commentArchiveModel, $commentModel)['comments'];
            }
        } else {
            return $this->error('Обьект комментария не найден');
        }

        return $this->success($comments);
    }

    public function batchDeleteComment($request, $commentClass = CommentModel::class)
    {
        if (Auth::user() && !Auth::user()->can('moderpool_comment_access', new CommentModel())) {
            return $this->error('Вы не можете удалять комментарии');
        }

        $data = $request->all();

        $validator = Validator::make($data, [
            'o' => 'required',
            'o_id' => 'required',
            'comments' => 'array|required'
        ], [
            'o.required' => 'Не задан параметр обьекта',
            'o_id.required' => 'Не задан параметр ID обьекта',
            'comments.required' => 'Не задан массив комментариев'
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        if (empty($data['comments'])) {
            return $this->error('Не задан массив комментариев');
        } else {
            $commentClass::whereIn('id', $data['comments'])
                ->where('object', $data['o'])
                ->where('object_id', $data['o_id'])->delete();
        }

        return $this->success();
    }

    public function moderateComment($request, $commmentClass = CommentModel::class)
    {
        $id = $request->input('id', 0);
        $moderated = $request->input('moderated', 0);
        $comment = $commmentClass::find($id);

        $authUser = Auth::user();
        $errorMesages = null;

        if ($comment && ($comment->author_id == $authUser->id || $authUser->superadmin == 1)) {
            $comment->update(['moderated' => $moderated]);
            $success = true;
        } else {
            $success = false;
            $errorMesages = ['id' => ['Access denied']];
        }
        if ($success == true) {
            return $this->success(['success' => $success, 'errors' => $errorMesages]);
        } else {
            return $this->error($errorMesages);
        }
    }

    public function batchMoveComment($request, $commentClass = CommentModel::class)
    {

        if (Auth::user() && !Auth::user()->can('moderpool_comment_access', new CommentModel())) {
            return $this->error('Вы не можете переносить комментарии');
        }

        $comment = null;
        $html = null;
        $data = $request->all();

        $validator = Validator::make($data, [
            'o' => 'required',
            'o_id' => 'required',
            'comments' => 'array|required',
            'new_o' => 'required',
            'new_o_id' => 'required'
        ], [
            'o.required' => 'Не задан параметр обьекта',
            'o_id.required' => 'Не задан параметр ID обьекта',
            'comments.required' => 'Не задан массив комментариев',
            'new_o_id.required' => 'Не задан обьект для переноса',
            'new_o.required' => 'Не задан ID обьекта для переноса'
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        if (empty($data['comments'])) {
            return $this->error('Не задан массив комментариев');
        } else {
            $objectInstance = app($data['new_o']);

            if ($objectInstance) {
                $object = $objectInstance->find($data['new_o_id']);
                if (!$object) {
                    return $this->error('Обьект для переноса не найден');
                }
            } else {
                return $this->error('Не найден обьект для переноса комментариев');
            }

            $commentClass::whereIn('id', $data['comments'])
                ->where('object', $data['o'])
                ->where('object_id', $data['o_id'])->update([
                    'o' => get_class($object),
                    'o_id' => $object->id
                ]);
        }

        return $this->success();
    }

    public function batchChangeStatusComment($request, $commentClass = CommentModel::class)
    {

        if (Auth::user() && !Auth::user()->can('moderpool_comment_access', new CommentModel())) {
            return $this->error('Вы не можете изменять статус комментариев');
        }

        $data = $request->all();

        $validator = Validator::make($data, [
            'o' => 'required',
            'o_id' => 'required',
            'comments' => 'array|required',
            'status' => 'required'
        ], [
            'o.required' => 'Не задан параметр обьекта',
            'o_id.required' => 'Не задан параметр ID обьекта',
            'comments.required' => 'Не задан массив комментариев',
            'status.required' => 'Не задан статус комментария'
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        if (empty($data['comments'])) {
            return $this->error('Не задан массив комментариев');
        } else {
            $sqlData = [
                'status' => $data['status']
            ];

            if ($data['status'] == $commentClass::STATUS_APPROVED) {
                $sqlData['moderator_id'] = Auth::user()->id;
                $sqlData['moderated'] = 1;
            } else {
                $sqlData['moderated'] = 0;
                $data['moderator_id'] = null;
            }

            $commentClass::whereIn('id', $data['comments'])
                ->where('object', $data['o'])
                ->where('object_id', $data['o_id'])->update($sqlData);
        }

        return $this->success();
    }

    public function archiveComment($request, $articleModel, $commentModel, $commentArchiveModel)
    {
        $articleId = $request->input('article_id');
        $fromDate = $request->get('from_date');

        if (!$articleId) {
            return $this->error('Не задан параметр ID');
        }

        $article = $articleModel::published()->active()->find($articleId);

        if (Auth::user()->can('article_comment_archive_manage', $article)) {
            return $this->error('Вы не имеете прав для архивации комментариев');
        }

        if (!$article) {
            return $this->error('Статья не найдена');
        } else {
            $comments = $this->loadComments($article, $articleModel, $commentArchiveModel, $commentModel)['comments'];

            if (empty($comments)) {
                return $this->error('Комментарии не найдены');
            } else {
                $commentArchive = $commentArchiveModel::where('article_id', $article->id)->first();
                $data = [
                    'article_id' => $article->id,
                    'from_date' => $fromDate
                ];

                if ($commentArchive) {
                    $commentArchiveModel::where('article_id', $article->id)->update([
                        'from_date' => $fromDate
                    ]);
                } else {
                    $commentArchiveModel::create($data);
                }
            }
        }

        return $this->success($article->commentArchive);
    }

    public function unpinComment($request, $commentModel)
    {
        $result = self::validatePin($request, $commentModel);

        if (!is_array($result)) {
            return $result;
        }

        $result['comment']->update(['pinned' => null]);

        return $this->success(['comment' => $result['comment']]);
    }

    public static function validatePin($request, $commentModel): bool|JsonResponse|string|array
    {
        $id = $request->input('id');

        if (!$id) {
            return Response::response()->error('Не задан параметр ID');
        }

        $comment = $commentModel::find($id);

        if (!$comment) {
            return Response::response()->error('Комментарий не найден');
        }

        return compact('comment');
    }

    public function pinComment($request, $commentModel)
    {

        $result = self::validatePin($request, $commentModel);

        if (!is_array($result)) {
            return $result;
        }

        $result['comment']->update(['pinned' => 1]);

        return $this->success(['comment' => $result['comment']]);
    }

    public function deleteComment($request, $commentModel, $articleModel)
    {
        $id = $request->input('id');
        $authUser = Auth::user();

        $comment = $commentModel::find($id);

        if ($authUser && $comment && $authUser->can('comment_delete', $comment)) {

            if ($comment->object == $articleModel) {
                $article = $articleModel::find($comment->object_id);
                if ($article) {
                    if ($article->comments_cnt > 0) {
                        $commentsTotal = $commentModel::where('object_id', $article->id)
                            ->where('object', $articleModel)
                            ->where('status', $commentModel::STATUS_APPROVED)->count('id');

                        $article->update(['comments_cnt' => $commentsTotal]);
                    }

                    if ($article->section) {
                        if ($article->section->comments_cnt > 0) {
                            $article->section->increment('comments_cnt', -1);
                        }
                    }
                }
            }

            $commentId = $comment->id;
            $comment->delete();

            $lastArticleComment = $articleModel::where('last_comment_id', $commentId)->get()->first();

            if ($lastArticleComment) {

                $lastComment = $commentModel::where('object', $articleModel)
                    ->where('object_id', $lastArticleComment->id)
                    ->orderBy('created_at', 'DESC')->limit(1)->first();

                if ($lastComment) {
                    $lastArticleComment->update([
                        'last_comment_id' => $lastComment->id,
                        'last_comment_at' => $lastComment->created_at,
                        'last_comment_author' => username($lastComment->author)
                    ]);

                } else {
                    $lastArticleComment->update([
                        'last_comment_id' => null,
                        'last_comment_at' => null,
                        'last_comment_author' => null
                    ]);
                }
            }

            Complain::query()->where(['object_id' => $comment->id, 'object' => $commentModel])->delete();

        } else {
            return $this->error('Вы не можете удалять комментарии');
        }

        return $this->success();
    }

    public function updateComment($request, $commentModel, $siteModel = Site::class)
    {
        $comment = null;

        $data = $request->all();
        $user = Auth::user();

        $validator = Validator::make($data, [
            'content' => 'required',
            'id' => 'required'
        ], [
            'content.required' => 'Напишите сообщение...',
            'id.required' => 'Не задан параметр ID'
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        if ($user) {

            $validationData = $validator->getData();
            $validationData['content'] = strip_tags($validationData['content']);

            if (empty($validationData['content'])) {
                return $this->error('Не заполнен контент');
            }

            $id = $data['id'];
            $content = $data['content'];
            $comment = $commentModel::with(['author'])->find($id);

            if (!$comment) {
                return $this->error('Комментарий не найден');
            }

            $content = preg_replace("/\s+/", " ", $content);
            $content = strip_tags($content);

            if (mb_strlen($content) >= 0 && mb_strlen($content) < 3) {
                return $this->error('Комментарий должен быть не менее 3 символов');
            }

            if ($user->can('comment_edit', $comment)) {

                $comment->update([
                    'content' => $this->parseContent($comment->object_id, $content),
                    'react_data' => isset($data['react_data']) ? $data['react_data'] : null
                ]);

                $objectData = app($comment->object)::find($comment->object_id);

                if ($objectData->section) {
                    $objectData->section->update([
                        'last_comment_id' => $comment->id,
                        'last_comment_date' => Carbon::now()->toDateTimeString()
                    ]);
                }

                activity(
                    $user,
                    $user,
                    ['o' => $commentModel, 'o_id' => $comment->id], ['from_o' => $comment->object, 'from_o_id' => $comment->object_id], null, null, ['comment' => $comment], $request, 1, 0);

            } else {
                return $this->error('У вас нет прав для редактирования комментария');
            }

        } else {
            $this->error('Вам нужно войти, чтоб добавить комментарий...');
        }

        $site = $this->getSiteByModel($siteModel);

        self::setAnnounceFromContent($data['content'], $comment, $site);

        return $this->success(['comment' => $comment]);
    }

    public function scopeAuthor($query)
    {
        return $query->where(env('DBU_DATABASE') . '.user.username', 'like', '%' . Input::get('author_username') . '%')
            ->leftJoin(env('DBU_DATABASE') . '.user', env('DBU_DATABASE') . '.user.id', '=', 'comment.author_id')
            ->select('comment.*');
    }

    public function scopeOnModeration($query)
    {
        return $query->where('status', self::STATUS_ON_MODERATION);
    }

    #[ArrayShape(['anchor' => "string", 'url' => "mixed"])]
    public function getOriginAttribute(): array
    {
        $object = app($this->object)->getApiUrl($this);

        return [
            'anchor' => '#c' . $this->id,
            'url' => $object
        ];
    }

    public function scopeBySite($query, $siteId)
    {
        return $query->where('site_id', $siteId);
    }
}