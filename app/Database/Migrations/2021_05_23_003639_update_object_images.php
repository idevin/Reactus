<?php

use App\Http\Controllers\Api\StorageController;
use App\Models\Article;
use App\Models\NeoCatalogField;
use App\Models\NeoUserCatalog;
use App\Models\Section;
use App\Models\StorageFile;
use App\Models\User;
use App\Models\UserStorageImage;
use App\Traits\Media;
use App\Traits\NeoObject;
use Illuminate\Database\Migrations\Migration;

class UpdateObjectImages extends Migration
{
    use Media;
    use NeoObject;

    public string $title = ' ';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->updateObjectThumbs('article_slider', Article::class);
        $this->updateObjectThumbs('section', Section::class);
        $this->updateCatalogs();
        $this->updateUserThumbs();
    }

    public function updateObjectThumbs(string $config, $modelClass)
    {
        $models = $modelClass::query()->withTrashed()->orderBy('image')->get();

        foreach ($models as $model) {
            if ($model->image) {
                $fileInfo = pathinfo($model->image);
                $extension = $fileInfo['extension'] ?? null;

                if ($extension && in_array($extension, ['jpg', 'jpeg', 'bmp', 'gif', 'png'])) {
                    $newFilename = $fileInfo['filename'] . '.webp';

                    $path = env('PUBLIC_PATH') . DS .
                        upload_path('storage/' . $config . '/thumbs/*/') . $fileInfo['filename'] . '.*';

                    self::deleteFiles($path);

                    foreach (config('image.thumb.' . $config) as $item) {
                        $options = self::getOptions($item);
                        $this->generateImage($options['width'], $options['height'], $newFilename,
                            $options['randColor'], $config, $model->title);
                    }

                    $model->update(['image' => $newFilename]);
                    $model->refresh();
                }
            }
        }
    }

    public static function deleteFiles($path)
    {
        $fs = new Illuminate\Filesystem\Filesystem();
        $found = $fs->glob($path);

        foreach ($found as $file) {
            if ($fs->exists($file)) {
                $success = $fs->delete($file);
                if (env('APP_DEBUG_VARS') == true) {
                    debugvars('file deleted: ' . $file, [$success]);
                }
            }
        }
    }

    public static function getOptions($item): array
    {
        $width = $item['size'][0];
        $height = $item['size'][1];
        $randColor = config('netgamer.colors')[mt_rand(0, count(config('netgamer.colors')) - 1)];
        self::$documentRoot = env('PUBLIC_PATH');

        return compact('width', 'height', 'randColor');
    }

    public function updateCatalogs()
    {
        $userCatalogData = NeoUserCatalog::query()->orderBy('catalog_name')->get();

        if (count($userCatalogData) > 0) {
            foreach ($userCatalogData as $datum) {
                if (!$datum->object) {
                    continue;
                }

                $cards = $datum->cards()->get();

                if (count($cards) > 0) {
                    foreach ($cards as $card) {
                        if ($card->userData && $card->userData->user_id) {
                            $user = User::find($card->userData->user_id);
                            if ($user) {
                                if (count($card->fieldUserGroups) > 0) {
                                    foreach ($card->fieldUserGroups as $fieldUserGroup) {
                                        if (count($fieldUserGroup->fields) > 0) {
                                            foreach ($fieldUserGroup->fields as $field) {
                                                $this->processField($field, $user);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function processField($field, $user)
    {
        if ($field->field) {
            if ($field->field->field_type['id'] == NeoCatalogField::FIELD_TYPE_IMAGE) {
                if (!empty($field->value)) {
                    $data = @file_get_contents($field->value);
                    if ($data) {
                        $data = json_decode($data, true);

                        if (count($data) > 0) {
                            $newData = [];
                            foreach ($data as $imgArray) {
                                $file = StorageFile::withTrashed()->find($imgArray['id']);

                                if ($file && $file->user_id == $user->id) {
                                    $domain = $user->domain;
                                    $url = $file->url;

                                    $parsedUrl = parse_url($url);
                                    $parsedUrl = $parsedUrl['path'] ?? null;
                                    if ($parsedUrl) {
                                        $fileInfo = pathinfo($file->filename);
                                        $extension = $fileInfo['extension'] ?? null;

                                        if (in_array($extension, ['jpg', 'jpeg', 'bmp', 'gif', 'png'])) {
                                            $request = self::setMigrationRequest($domain, $url, $file);

                                            Auth::login($user, true);

                                            $newFile = app(StorageController::class)->addBase64Files($request);
                                            $allData = $newFile->getData()->data;

                                            if (!empty($allData)) {
                                                $allData[0]->url_miniature = $allData[0]->thumb1920x1080;
                                                $allData[0]->srcMiniature = $allData[0]->thumb280x157;
                                                $allData[0]->src = $allData[0]->thumb1920x1080;
                                                $newData[] = $allData[0];
                                            }

                                            self::deleteFile($file);
                                        }
                                    }
                                }
                            }
                            $newData = array_filter($newData);
                            if (!empty($newData)) {
                                $newData = json_encode($newData, JSON_UNESCAPED_UNICODE |
                                    JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);

                                file_put_contents($field->value, $newData);
                            }
                        }
                    }
                }
            }
        }
    }

    public function updateUserThumbs()
    {
        $users = User::all();
        if (count($users) > 0) {
            foreach ($users as $user) {
                if ($user->image) {
                    $fileInfo = pathinfo($user->image);
                    $extension = $fileInfo['extension'] ?? null;

                    if (in_array($extension, ['jpg', 'jpeg', 'bmp', 'gif', 'png'])) {
                        $newFilename = $fileInfo['filename'] . generate_code(2, true) . '.webp';

                        $path = env('PUBLIC_PATH') . DS .
                            upload_path('storage/avatar/thumbs/*/') . $fileInfo['filename'] . '.*';

                        self::deleteFiles($path);

                        foreach (config('image.thumb.avatar') as $item) {
                            $options = self::getOptions($item);
                            $this->generateImage($options['width'], $options['height'], $newFilename,
                                $options['randColor'], 'avatar', ' ');
                        }

                        $user->update(['image' => $newFilename]);
                        $user->refresh();


                    }
                } else {
                    $image = UserStorageImage::withTrashed()->whereUserId($user->id)
                        ->whereType(UserStorageImage::IMAGE)->first();

                    if ($image && $image->storageFile) {

                        $fileInfo = pathinfo($image->storageFile->filename);
                        $extension = $fileInfo['extension'] ?? null;

                        if (in_array($extension, ['jpg', 'jpeg', 'bmp', 'gif', 'png'])) {
                            $path = env('PUBLIC_PATH') . DS .
                                upload_path('storage/storage/thumbs/*/') . $fileInfo['filename'] . '.*';

                            self::deleteFiles($path);

                            $url = getSchema() . $user->domain . $image->storageFile->url .
                                $image->storageFile->filename;

                            $request = request();
                            $request->query->add(['files' => [[
                                'url' => $url,
                                'title' => $image->storageFile->title,
                                'description' => $image->storageFile->descirption,
                                'id' => null
                            ]]]);

                            Auth::login($user, true);

                            $newFile = app(StorageController::class)->addBase64Files($request);
                            $allData = $newFile->getData()->data;

                            try {
                                $image->storageFile->forceDelete();
                            } catch (Exception $e) {
                                if (env('APP_DEBUG_VARS') == true) {
                                    debugvars($e->getMessage(), $e->getTrace());
                                }
                            }

                            UserStorageImage::firstOrCreate([
                                'type' => UserStorageImage::IMAGE,
                                'storage_file_id' => $allData[0]->id,
                                'user_id' => $user->id
                            ]);
                        }
                    }
                }
            }

            $redis = new Predis\Client(config('database.connections.redis.default'),
                config('database.connections.redis.options'));
            $redis->flushall();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

