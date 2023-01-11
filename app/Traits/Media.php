<?php

namespace App\Traits;

use App\Models\SiteStorageImage;
use App\Models\StorageFile;
use App\Models\UserStorageImage;
use Auth;
use Cache;
use Exception;
use File;
use finfo;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use ImageTool;
use Imagick;
use ImagickException;
use Ixudra\Curl\Facades\Curl;
use RuntimeException;
use SplFileInfo;
use function imagecolorallocate;
use function imagecreatetruecolor;
use function imagefill;
use function imagepng;
use function ob_end_clean;
use function ob_get_contents;
use function ob_start;

trait Media
{
    use Site;

    public static $documentRoot = null;

    /**
     * @param $imageName
     * @param string $folder
     */
    public static function deleteImage($imageName, string $folder = 'article')
    {
        $thumbs = config('image.thumb.' . $folder);
        $fs = new Filesystem();
        $toDelete = [];

        $root = Media::getImageRoot();

        $path = $root . DS . 'uploads' . DS . 'storage' . DS . $folder;
        $originalImage = $path . DS . $imageName;

        foreach ($thumbs as $item) {
            $w = $item['size'][0];
            $h = $item['size'][1];
            $fullPath = $path . DS . 'thumbs' . DS . $w . 'x' . $h . DS . $imageName;
            if (file_exists($fullPath)) {
                $toDelete[] = $fullPath;
            }
        }

        if (file_exists($originalImage)) {
            $toDelete[] = $originalImage;
        }

        $fs->delete($toDelete);
    }

    public static function getImageRoot(): string
    {
        if (self::$documentRoot == null) {
            $root = env('PUBLIC_PATH');
        } else {
            $root = Media::$documentRoot;
        }

        return trim($root, '_');
    }

    public function originalImageUrl($config, $image, $user = null): string
    {
        $originalPath = '';

        if ($image) {
            $path = DS . config('netgamer.upload_dir') . DS . 'storage' . DS . $config . DS . $image;
            $originalPath = $path;

            if ($user) {
                $originalPath = getSchema() . $user->domain . $originalPath;
            }
        }

        return $originalPath;
    }

    public function imageUrl($folder, $config, $imageName = null)
    {
        $color = $this->getColor();
        $root = self::getImageRoot();

        list($width, $height) = preg_split('/x/', $folder);

        if ($imageName) {
            $image = $imageName;
        } else {
            $image = $this->image;
        }

        if ($image) {

            $path = DS . config('netgamer.upload_dir') . DS . 'storage' . DS . $config . DS . 'thumbs' . DS;

            $originalPath = $root . DS .
                config('netgamer.upload_dir') . DS . 'storage' . DS . $config . DS . $image;

            $url = $path . $folder . DS . $image;

            $urlPath = $root . DS . config('netgamer.upload_dir') . DS .
                'storage' . DS . $config . DS . 'thumbs' . DS . $width . 'x' . $height . DS . $image;

            if (file_exists($originalPath)) {

                if (!file_exists($urlPath)) {

                    $configArray = [
                        [
                            'size' => [$width, $height],
                            'generateImage' => true,
                            'watermark' => false,
                            'text' => false,
                            'color' => null
                        ]
                    ];

                    try {
                        $file = $this->createThumbs($originalPath, $configArray, $config);
                        $url = $file["thumb" . $width . 'x' . $height] ?? null;

                    } catch (ImagickException $e) {
                        debugvars($e->getMessage(), ['trace' => $e->getTraceAsString()]);
                    }

                    return $url;
                } else {
                    return $path . $width . 'x' . $height . DS . $image;
                }
            } else {
                if (!file_exists($urlPath)) {

                    $image = basename($image);

                    $url = $this->generateImage($width, $height, $image, $color, $config);
                }
            }
        } else {
            $imageRandomName = $this->getImageName();
            $this->image = $imageRandomName;
            $this->update([
                'image' => $imageRandomName
            ]);

            $url = $this->generateImage($width, $height, $imageRandomName, $color, $config);
        }
        $imageInfo = pathinfo($root . $url);
        $ext = (isset($imageInfo['extension']) && !empty($imageInfo['extension'])) ? $imageInfo['extension'] : null;

        if (!empty($ext) && !in_array($ext, ['jpg', 'jpeg'])) {
            $url = Media::convertToJpg($this, $root . $url, $fullPath = false);
        }

        return $url;
    }

    public function getColor()
    {
        $key = $this->getModelKey();
        $cachedColor = Cache::get($key);
        if (!$cachedColor) {
            $randColor = config('netgamer.colors')[mt_rand(0, count(config('netgamer.colors')) - 1)];
            $cachedColor = Cache::rememberForever($key, function () use ($randColor) {
                return $randColor;
            });
        }

        return $cachedColor;
    }

    public function getModelKey(): string
    {
        return get_class($this) . '.' . ($this->id ?? null);
    }

    public static function call(): object
    {
        return new class {
            use Media;
        };
    }

    /**
     * @param $file
     * @param array $thumbs
     * @param string $folder
     * @param null $text
     * @param null $user
     * @return array|null
     * @throws ImagickException
     */
    public function createThumbs($file, $thumbs = [], $folder = '', $text = null, $user = null): array
    {
        $path = null;
        $fileInfo = new SplFileInfo($file);
        $extension = $fileInfo->getExtension();

        if ($extension == 'svg') {
            $image = new Imagick();
            $svg = file_get_contents($file);
            $file = $file . '.jpg';

            $image->readImageBlob($svg);
            $image->setImageFormat("jpg");
            $image->setImageCompression(Imagick::COMPRESSION_UNDEFINED);
            $image->setImageCompressionQuality(0);
            $image->stripImage();
            $image->writeImage($file);
            $image->clear();
            $image->destroy();

            $fileInfo = new SplFileInfo($file);
        }

        $extensions = array_keys(config('netgamer.scoped_image_types'));

        if (!in_array($fileInfo->getExtension(), $extensions)) {

            $data = [];
            foreach ($thumbs as $item) {
                $data["thumb{$item['size'][0]}x{$item['size'][1]}"] = null;
            }

            return $data;
        }

        $result = null;

        if (file_exists($file)) {
            if ($extension == 'gif') {
                $result = $this->processGif($folder, $thumbs, $fileInfo, $user);
            } else {
                $result = $this->processDefault($file, $folder, $thumbs, $text, $fileInfo, $user);
            }
        }

        return $result;
    }

    /**
     * @param $folder
     * @param $thumbs
     * @param $fileInfo
     * @param $user
     * @return array
     */
    protected function processGif($folder, $thumbs, $fileInfo, $user = null): array
    {
        $result = [];
        $filename = $fileInfo->getFilename();

        foreach ($thumbs as $item) {
            $result["thumb{$item['size'][0]}x{$item['size'][1]}"] = DS . 'uploads' . DS .
                'storage' . DS . $folder . DS . $filename;
        }

        $userPath = '';

        if ($user) {
            $userPath = getSchema() . $user->domain;
        }

        $result['original'] = $userPath . DS . 'uploads' . DS . 'storage' . DS . $folder .
            DS . $filename;

        return $result;
    }

    protected function processDefault($file, $folder, $thumbs, $text, $fileInfo, $user = null): array
    {
        $result = [];
        try {
            $imgTool = ImageTool::make($file);
        } catch (RuntimeException $e) {
            return $result;
        }

        $root = Media::getImageRoot();

        foreach ($thumbs as $item) {

            $width = $item['size'][0];
            $height = $item['size'][1];
            $thumbsFolder = DS . $folder . DS . 'thumbs' . DS . "{$item['size'][0]}x{$item['size'][1]}" . DS;
            $path = $this->getPath($thumbsFolder);

            $image = DS . 'uploads' . DS . 'storage' . DS .
                $thumbsFolder . DS . $fileInfo->getFilename();

            if (!file_exists($path . $fileInfo->getFilename())) {

                if ($item['generateImage'] == true) {

                    $imgTool->fit($width, $height, null, 'center');

                    if ($text && $item['text'] == true) {

                        $text = $this->getText($text);

                        $imgTool->text($text, $width / 2, $height / 2, function ($font) use ($root) {

                            $font->file($root . DS .
                                'assets' . DS . 'fonts' . DS . 'pt-sans-regular.ttf');

                            $font->size(22);
                            $font->color([255, 255, 255]);
                            $font->align('center');
                            $font->valign('middle');
                        });
                    }

                    if ($item['watermark'] == true) {

                        $watermark = ImageTool::make($root . DS . 'assets' . DS . 'img' . DS . 'circle.png');
                        $watermark->resize((int)($height / 2.5), (int)($height / 2.5));
                        $imgTool->insert($watermark, 'center');
                    }

                    $imgTool->save($path . $fileInfo->getFilename(), 70);

                } else {
                    $result["thumb{$item['size'][0]}x{$item['size'][1]}"] = null;
                }
            }

            $result["thumb{$item['size'][0]}x{$item['size'][1]}"] = $image;
        }

        $result['filename'] = $fileInfo->getFilename();

        $userPath = '';

        if ($user) {
            $userPath = getSchema() . $user->domain;
        }

        $result['original'] = $userPath . DS . 'uploads' . DS . 'storage' . DS . $folder .
            DS . $fileInfo->getFilename();

        return $result;
    }

    public function getText($textInside = null)
    {
        if (!$textInside) {
            $textInside = $this->title;
        }

        $i = 0;
        $text = null;

        if (!empty($textInside)) {
            $textInside = trim($textInside);
            while (1) {
                /**
                 * @todo refactor this
                 */
                if ($i == 0) {
                    $text = mb_substr($textInside, $i, 1, 'utf-8');
                } else {
                    $text = mb_substr($textInside, $i, $i, 'utf-8');
                }

                $i++;

                if (!empty($text)) {
                    break;
                }
            }
        }

        return $text;
    }

    public function generateImage($width, $height, $imageName, $color, $config, $textInside = null): ?string
    {
        $imageName = $imageName ? basename($imageName) : null;

        if (!$color) {
            $color = $this->getColor();
        }

        $imageConfig = null;
        $root = Media::getImageRoot();

        foreach (config('image.thumb.' . $config) as $item) {
            if ($item['size'][0] == $width && $item['size'][1] == $height) {
                $imageConfig = $item;
                break;
            }
        }

        if ($imageConfig && $imageConfig['generateImage'] == true) {
            $fs = new Filesystem();

            $oImage = imagecreatetruecolor($width, $height);
            $background = imagecolorallocate($oImage, $color[0], $color[1], $color[2]);
            imagefill($oImage, 0, 0, $background);
            ob_start();
            imagepng($oImage);
            $imageData = ob_get_contents();
            ob_end_clean();

            if ($imageData) {

                $originalPath = $root . DS . config('netgamer.upload_dir') . DS .
                    'storage' . DS . $config . DS . 'thumbs' . DS . $width . 'x' . $height . DS;

                if (!file_exists($originalPath)) {
                    $fs->makeDirectory($originalPath, 0755, true);
                }

                $imageExtension = 'jpg';

                if (strstr($imageName, '.') != false) {

                    $imgParts = preg_split('#\.#', $imageName);
                    $imageName = $imgParts[0];
                    $imageExtension = '.' . last($imgParts);

                } else {
                    $imageName = $imageName . '.' . $imageExtension;
                }

                $original = $originalPath . DS . $imageName;

                $text = $this->getText($textInside);

                $width = $imageConfig['size'][0];
                $height = $imageConfig['size'][1];

                $thumbsFolder = DS . config('netgamer.upload_dir') . DS .
                    'storage' . DS . $config . DS . 'thumbs' . DS . $width . 'x' . $height . DS;

                $image = $thumbsFolder . DS . basename($imageName . $imageExtension);

                if (!file_exists($original . $imageExtension)) {

                    if ($fs->exists($originalPath) && $fs->isWritable($originalPath)) {

                        file_put_contents($original . $imageExtension, $imageData);

                        $imgTool = ImageTool::make($original . $imageExtension);

                        $imgTool->fit($width, $height);

                        if ($text && $imageConfig['text'] == true) {

                            $imgTool->text($text, $width / 2, $height / 2, function ($font) use ($root) {

                                $fullRoot = $root . DS . 'assets' . DS . 'fonts' . DS . 'pt-sans-regular.ttf';
                                $font->file($fullRoot);

                                $font->size(22);
                                $font->color([255, 255, 255]);
                                $font->align('center');
                                $font->valign('middle');
                            });
                        }

                        if ($imageConfig['watermark'] == true) {

                            $watermark = ImageTool::make($root . DS . 'assets' . DS . 'img' . DS . 'circle.png');
                            $watermark->resize((int)($height / 2.5), (int)($height / 2.5));
                            $imgTool->insert($watermark, 'center');
                        }

                        $parsedPath = parse_url($original . $imageExtension);

                        $imgTool->save($parsedPath['path'], 95);
                    }
                }

                return $image;
            }
        }

        return null;
    }

    public function getImageName(): string
    {
        return Str::random(18) . '.jpg';
    }

    public static function convertToJpg($object, $path, $fullPath = true)
    {
        $imageInfo = pathinfo($path);
        $ext = $imageInfo['extension'];

        if (empty($ext)) {
            return new Exception("NO EXTENSION!");
        }

        $newFileName = $imageInfo['filename'] . '.jpg';
        $newPath = $imageInfo['dirname'] . DS . $newFileName;

        if (!file_exists($newPath)) {
            if (preg_match('/jpg|jpeg/i', $ext)) {
                $imageTmp = imagecreatefromjpeg($path);
            } else if (preg_match('/png/i', $ext)) {
                $imageTmp = imagecreatefrompng($path);
            } else if (preg_match('/bmp/i', $ext)) {
                $imageTmp = imagecreatefrombmp($path);
            } else {
                return null;
            }

            imagejpeg($imageTmp, $newPath, 70);
            imagedestroy($imageTmp);
            if (env('APP_DEBUG_VARS') == true) {
                debugvars("GENERATE JPG: " . $newPath);
            }
        }

        if ($fullPath == false) {
            $path = explode(Media::getImageRoot(), $newPath);
            $path = $path[1];
        } else {
            $path = $newPath;
        }

        if ($object->image) {
            $object->update([
                'image' => $newFileName
            ]);
        }

        return $path;
    }

    /**
     * @param $image
     * @param string $contentType
     * @param null $thumbConfig
     * @return array|null
     * @throws ImagickException
     */
    public function createStorageThumbs($image, $contentType = 'storage', $thumbConfig = null): array
    {
        if (empty($image) || empty($contentType)) {
            return [];
        } else {
            if ($thumbConfig) {
                $thumbsConfig = [$thumbConfig];
            } else {
                $thumbsConfig = config('image.thumb.' . $contentType);
            }

            return $this->createThumbs($image, $thumbsConfig, $contentType);
        }
    }

    public function processArticleSlides($data, $article, $articleImageModel)
    {
        if (!empty($data['images'])) {
            $imagesCollection = collect($data['images']);

            $slides = $imagesCollection->pluck('id');
            $storageSlides = $articleImageModel::where('article_id', $article->id)
                ->orderBy('sort_order', 'asc')->get()->pluck('storage_file_id');

            $toDelete = $storageSlides->diff($slides)->toArray();

            if (count($toDelete) > 0) {
                $articleImageModel::whereIn('storage_file_id', $toDelete)->forceDelete();
            }

            if (count($imagesCollection) > 0) {

                $imagesCollection->map(function ($image) use ($article, $articleImageModel) {
                    if ((int)$image['id'] > 0) {
                        $articleImageModel::firstOrCreate([
                            'article_id' => $article->id,
                            'storage_file_id' => $image['id'],
                            'sort_order' => isset($image['sort_order']) ? (int)$image['sort_order'] : 0
                        ]);
                    }
                });
            }
        }
    }

    public function processSiteSlides($data, $site)
    {
        if (!empty($data['site_preview'])) {
            $imagesCollection = collect($data['site_preview']);
            $slides = $imagesCollection->pluck('id');

            $storageSlides = SiteStorageImage::whereSiteId($site->id)->orderBy('sort_order', 'asc')
                ->whereType(SiteStorageImage::IMAGE)->get()->pluck('storage_file_id');

            $toDelete = $storageSlides->diff($slides)->toArray();

            if (count($toDelete) > 0) {
                (new \App\Models\SiteStorageImage)->whereIn('storage_file_id', $toDelete)->forceDelete();
            }

            if (count($imagesCollection) > 0) {

                $imagesCollection->map(function ($image) use ($site) {

                    SiteStorageImage::firstOrCreate([
                        'site_id' => $site->id,
                        'storage_file_id' => $image['id'],
                        'type' => SiteStorageImage::IMAGE,
                        'sort_order' => isset($image['sort_order']) ? (int)$image['sort_order'] : 0
                    ]);
                });
            }
        }
    }

    public function processSectionSlides($data, $section, $sectionImageModel)
    {
        if (!empty($data['images'])) {
            $slidesCollection = collect($data['images']);
            $images = $slidesCollection->pluck('id');

            $storageSlides = $sectionImageModel::whereSectionId($section->id)
                ->orderBy('sort_order', 'asc')->get()->pluck('storage_file_id');

            $toDelete = $storageSlides->diff($images)->toArray();

            if (count($toDelete) > 0) {
                $sectionImageModel::whereIn('storage_file_id', $toDelete)->forceDelete();
            }

            if (count($slidesCollection) > 0) {

                $slidesCollection->map(function ($image) use ($section, $sectionImageModel) {
                    if ((int)$image['id'] > 0) {
                        $sectionImageModel::firstOrCreate([
                            'section_id' => $section->id,
                            'storage_file_id' => $image['id'],
                            'sort_order' => isset($image['sort_order']) ? (int)$image['sort_order'] : 0
                        ]);
                    }
                });
            }
        }
    }

    public static function saveSiteStorage($site, $data, $type)
    {
        $image = null;

        if (!empty($data)) {

            $file = StorageFile::query()->find($data['id']);

            if ($file) {
                $file->update([
                    'title' => isset($data['title']) ? $data['title'] : null,
                    'description' => isset($data['description']) ? $data['description'] : null
                ]);
            }

            $image = SiteStorageImage::query()->whereSiteId($site->id)
                ->whereType($type)->first();

            $imageData = [
                'site_id' => $site->id,
                'storage_file_id' => $data['id'],
                'type' => $type
            ];

            if ($image) {
                $image->update($imageData);
                $image = $image->refresh();
            } else {
                $image = SiteStorageImage::firstOrCreate($imageData);
            }
        }

        return $image;
    }

    public function saveUserStorage($user, $data, $type)
    {
        if (!empty($data)) {

            $file = StorageFile::find($data['id']);

            if ($file) {
                $file->update([
                    'title' => isset($data['title']) ? $data['title'] : null,
                    'description' => isset($data['description']) ? $data['description'] : null
                ]);
            }

            $image = UserStorageImage::whereUserId($user->id)
                ->whereType((int)$type)->first();

            $imageData = [
                'user_id' => $user->id,
                'storage_file_id' => $data['id'],
                'type' => (int)$type
            ];

            if ($image) {
                $image->update($imageData);
            } else {
                UserStorageImage::firstOrCreate($imageData);
            }
        }
    }

    public function deleteUserStorageImage($user, $type)
    {
        UserStorageImage::whereUserId($user->id)->where('type', $type)->forceDelete();
    }

    public static function deleteSiteStorageImage($site, $type)
    {
        SiteStorageImage::query()->where('site_id', $site->id)->where('type', $type)->forceDelete();
    }

    public function deleteArticleStorageImages($article, $articleImageModel)
    {
        $articleImageModel::where('article_id', $article->id)->forceDelete();
    }

    public function deleteSiteStorageImages($site)
    {
        SiteStorageImage::whereSiteId($site->id)
            ->whereType(SiteStorageImage::IMAGE)->forceDelete();
    }

    public function deleteSectionStorageImages($section, $sectionImageModel)
    {
        $sectionImageModel::where('section_id', $section->id)->forceDelete();
    }

    /**
     * @param $imageData
     * @param $folder
     * @param $user
     * @param null $filename
     * @return null|string
     * @throws ImagickException
     */
    public function copyBatchSectionImages($imageData, $folder, $user, $filename = null)
    {
        $hash = $filename ? $filename : generate_code(16, true);
        $newFilename = $hash;

        $root = Media::getImageRoot();

        $sectionPath = $root . DS . config('netgamer.upload_dir') .
            DS . 'storage' . DS . $folder . DS;

        if (!empty($imageData['images']['original'])) {

            if (strstr($imageData['images']['original']['data'], 'data:')) {
                $base64Image = $imageData['images']['original']['data'];

                $base64Img = explode(',', $base64Image);
                $base64Img[1] = str_replace(' ', '+', $base64Img[1]);
                $binImage = base64_decode($base64Img[1]);

                $finfo = new finfo(FILEINFO_MIME_TYPE);
                $mimeType = $finfo->buffer($binImage);

                if (!in_array($mimeType, array_values(config('netgamer.scoped_image_types')))) {
                    return null;
                }

                $mimeTypeParsed = preg_split('#/#', $mimeType);
                $extension = $mimeTypeParsed[1];

                if ($extension == 'jpeg') {
                    $extension = 'jpg';
                }

                $fs = new Filesystem();

                $hash = generate_code(16, true);

                $path = StorageFile::STORAGE_PATH . $user->id . DS . $hash[0] .
                    $hash[1] . DS . $hash[2] . $hash[3] . DS . $hash[4] . DS . $extension . DS;

                $root = Media::getImageRoot();

                $tmpPath = $root . DS . $path;

                $newFilename .= '.' . $extension;

                if (!file_exists($sectionPath)) {
                    $fs->makeDirectory($sectionPath, 0755, true);
                }

                if (!file_exists($tmpPath)) {
                    $fs->makeDirectory($tmpPath, 0755, true);
                }

                file_put_contents($tmpPath . $newFilename, $binImage);
                file_put_contents($sectionPath . $newFilename, $binImage);

                $root = Media::getImageRoot();

                $data = [
                    'user_id' => $user->id,
                    'filename' => $newFilename,
                    'type' => $mimeType,
                    'size' => File::size($tmpPath . $newFilename),
                    'hash' => $hash,
                    'extension' => $extension,
                    'url' => $path,
                    'path' => $root . DS . $path . $newFilename
                ];

                StorageFile::create($data);
            } else {
                $newFilename = $imageData['images']['original']['name'];
            }

            foreach ($imageData['images'] as $thumb => &$image) {
                if (strstr($thumb, 'x')) {

                    if (strstr($image, 'data:')) {
                        $base64Img = explode(',', $image);
                        $base64Img[1] = str_replace(' ', '+', $base64Img[1]);
                        $binImage = base64_decode($base64Img[1]);

                        $finfo = new finfo(FILEINFO_MIME_TYPE);
                        $mimeType = $finfo->buffer($binImage);

                        if (!in_array($mimeType, array_values(config('netgamer.scoped_image_types')))) {
                            return null;
                        }

                        $fs = new Filesystem();
                        $thumb = preg_replace('#thumb#', '', $thumb);

                        list($width, $height) = preg_split('#x#', $thumb);

                        $root = Media::getImageRoot();

                        $fullPath = $root . DS . config('netgamer.upload_dir') .
                            DS . 'storage' . DS . $folder . DS . 'thumbs' . DS . $width . 'x' . $height . DS;
                        $tmpPath = sys_get_temp_dir() . DS;

                        if (!file_exists($tmpPath)) {
                            $fs->makeDirectory($tmpPath, 0755, true);
                        }

                        if (!strstr($newFilename, '.')) {
                            $imageType = preg_split('#/#', $mimeType);
                            $newFilename .= '.' . $imageType[1];
                        }

                        file_put_contents($tmpPath . $newFilename, $binImage);

                        if (file_exists($tmpPath . $newFilename)) {

                            if (file_exists($fullPath . $newFilename)) {
                                $fs->delete($fullPath . $newFilename);
                            }

                            $extension = pathinfo($tmpPath . $newFilename, PATHINFO_EXTENSION);

                            $thumbs = [[
                                'size' => [$width, $height],
                                'generateImage' => true,
                                'watermark' => false,
                                'text' => false,
                                'color' => null
                            ]];

                            $fileInfo = new SplFileInfo($tmpPath . $newFilename);

                            if ($extension == 'gif') {
                                $this->processGif($folder, $thumbs, $fileInfo);
                            } else {
                                $this->processDefault($tmpPath . $newFilename, $folder, $thumbs, null, $fileInfo);
                            }
                        }
                    }
                }
            }
        }

        return $newFilename;
    }

    public function checkMimeType($base64Data)
    {
        if (strstr($base64Data, 'data:')) {
            $base64Img = preg_split('/\,/', $base64Data);
            if (isset($base64Img[0])) {
                $mimeData = preg_replace('#data\:|base64|;#', '', $base64Img[0]);
                if (!empty($mimeData)) {
                    if (!in_array($mimeData, array_values(config('netgamer.scoped_image_types')))) {
                        return false;
                    }
                } else {
                    return false;
                }
            }
        }

        return true;
    }

    protected function copyBase64Images($data, $object, $folder = 'section')
    {
        $original = null;
        $imageName = null;
        $fs = new Filesystem();

        $root = Media::getImageRoot();

        if (isset($data['original']) && isset($data['original']['name'])) {
            $object->update([
                'image' => $data['original']['name']
            ]);
            if (strstr($data['original']['data'], 'data:')) {
                $saveOriginalPath = $root . DS . 'uploads' . DS . 'storage' . DS . $folder;

                $base64Img = explode(',', $data['original']['data']);
                $base64Img[1] = str_replace(' ', '+', $base64Img[1]);
                $binImage = base64_decode($base64Img[1]);

                if (!file_exists($saveOriginalPath)) {
                    $fs->makeDirectory($saveOriginalPath, 0755, true);
                }

                if (isset($data['original']) && isset($data['original']['name'])) {
                    file_put_contents($saveOriginalPath . DS . $data['original']['name'], $binImage);
                }
            }
        }

        foreach ($data as $index => $value) {
            if (!is_array($value)) {

                preg_match('#thumb(\d+)x(\d+)#', $index, $imgAttribites);

                if (!empty($imgAttribites) && count($imgAttribites) == 3) {
                    $w = $imgAttribites[1];
                    $h = $imgAttribites[2];

                    $savePath = $root . DS . 'uploads' . DS . 'storage' .
                        DS . $folder . DS . 'thumbs' . DS . $w . 'x' . $h;

                    if (strstr($value, 'data:')) {
                        $base64Img = explode(',', $value);
                        $base64Img[1] = str_replace(' ', '+', $base64Img[1]);
                        $binImage = base64_decode($base64Img[1]);

                        if (!file_exists($savePath)) {
                            $fs->makeDirectory($savePath, 0755, true);
                        }

                        if (isset($data['original']) && isset($data['original']['name'])) {
                            file_put_contents($savePath . DS . $data['original']['name'], $binImage);
                        }
                    }
                }
            }
        }

        return null;
    }

    protected function saveSectionImages($data, $user, $folder = 'section')
    {
        $original = null;
        $imageName = null;

        $root = Media::getImageRoot();

        if (isset($data['original']) && isset($data['original']['name'])) {

            if (strstr($data['original']['data'], 'data:')) {

                $base64Img = preg_split('/\,/', $data['original']['data']);
                $base64Img[1] = str_replace(' ', '+', $base64Img[1]);
                $binImage = base64_decode($base64Img[1]);

                $finfo = new finfo(FILEINFO_MIME_TYPE);
                $mimeType = $finfo->buffer($binImage);

                if (!in_array($mimeType, array_values(config('netgamer.scoped_image_types')))) {
                    return null;
                }

                $mimeTypeFromBin = preg_split('/;/', $base64Img[0]);

                if (isset($mimeTypeFromBin[0])) {
                    $mimeTypeFromBin = preg_split('/:/', $mimeTypeFromBin[0]);
                    if (isset($mimeTypeFromBin[1])) {
                        $mimeType = $mimeTypeFromBin[1];
                    }
                }

                $mimeTypeParsed = preg_split('#/#', $mimeType);

                $extension = $mimeTypeParsed[1];

                if ($extension == 'jpeg') {
                    $extension = 'jpg';
                    $mimeType = 'image/jpeg';
                }

                $fs = new Filesystem();

                $hash = generate_code(16, true);

                $defaultPath = StorageFile::STORAGE_PATH . $user->id . DS . $hash[0] .
                    $hash[1] . DS . $hash[2] . $hash[3] . DS . $hash[4] . DS;

                $path = $defaultPath . $extension . DS;

                $fullPath = $root . DS . $path;

                $newFilename = $hash . '.' . $extension;

                if (in_array($extension, ['png', 'bmp'])) {
                    $path = $defaultPath . 'jpg' . DS;
                    $fullPath = $root . DS . $path;
                }

                if (!file_exists($fullPath)) {
                    $fs->makeDirectory($fullPath, 0755, true);
                }

                switch ($extension) {
                    case 'png':
                        $png = imagecreatefromstring($binImage);
                        $whiteBack = imagecreatetruecolor(imagesx($png), imagesy($png));

                        imagefill($whiteBack, 0, 0, imagecolorallocate($whiteBack, 255, 255, 255));
                        imagealphablending($whiteBack, true);
                        imagecopy($whiteBack, $png, 0, 0, 0, 0, imagesx($png), imagesy($png));
                        imagejpeg($whiteBack, $fullPath . $hash . '.jpg', 55);
                        imagedestroy($whiteBack);
                        imagedestroy($png);

                        $newFilename = $hash . '.jpg';
                        break;

                    case 'jpg':
                        $jpg = imagecreatefromstring($binImage);
                        imagejpeg($jpg, $fullPath . $hash . '.' . $extension, 55);
                        imagedestroy($jpg);
                        break;

                    case 'gif':

                        file_put_contents($fullPath . $newFilename, $binImage);

                        $image = new Imagick($fullPath . $newFilename);
                        $image->optimizeImageLayers();
                        $image->writeImages($fullPath . $newFilename, true);
                        $image->destroy();
                        break;

                    default:
                        file_put_contents($fullPath . $newFilename, $binImage);
                        break;
                }

                StorageFile::create([
                    'user_id' => $user->id,
                    'filename' => $newFilename,
                    'type' => $mimeType,
                    'size' => File::size($fullPath . $newFilename),
                    'hash' => $hash,
                    'extension' => $extension,
                    'url' => $path
                ]);

                $configSettings = config('image.thumb.' . $folder);

                $config = collect($configSettings)->map(function ($item) {
                    return [
                        'size' => $item['size'],
                        'generateImage' => true,
                        'watermark' => false,
                        'text' => false,
                        'color' => null
                    ];
                });

                $imgData = $this->createThumbs($fullPath . $newFilename, $config, $folder);

                $this->saveOriginal($data['original']['data'], $folder, $newFilename);

                return $imgData;
            }
        }

        return null;
    }

    protected function saveOriginal($data, $folder = 'article_slider', $imageName = null)
    {
        if (preg_match('/data:/', $data)) {

            $base64Img = preg_split('/,/', $data);
            $base64Img[1] = preg_replace('/\s+/', '+', $base64Img[1]);
            $binImage = base64_decode($base64Img[1]);

            $fs = new Filesystem();

            if (!$imageName) {
                $imgName = $this->getImageName();
            } else {
                $imgName = $imageName;
            }

            $root = Media::getImageRoot();

            $relativePath = DS . config('netgamer.upload_dir') . DS . 'storage' . DS . $folder;
            $fullPath = $root . $relativePath . DS;

            if (!file_exists($fullPath)) {
                $fs->makeDirectory($fullPath, 0755, true);
            }

            $imgPath = $fullPath . DS . $imgName;

            file_put_contents($imgPath, $binImage);

            return ['filename' => $imgName];
        }

        return null;
    }

    protected function getPath($thumbsFolder): ?string
    {
        $root = Media::getImageRoot();

        if ($root) {
            $path = $root . DS . 'uploads' . DS . 'storage' . DS . $thumbsFolder;

            if (!file_exists($path)) {
                $fs = new Filesystem();
                $fs->makeDirectory($path, 0755, true);
            }
            return $path;
        }

        return null;
    }

    protected function saveUrl($file, $saveParams): ?array
    {
        $extension = pathinfo($file['url'], PATHINFO_EXTENSION);
        $response = null;
        $image = false;
        $imageData = null;

        $filename = generate_code(16, true);

        if (empty($extension)) {
            $info = @getimagesize($file['url']);
            $extension = @image_type_to_extension($info[2]);
            $extension = preg_replace('#\.#', '', $extension);
        }

        if (in_array($extension, array_keys(config('netgamer.scoped_image_types')))) {

            $filePath = DS . sys_get_temp_dir() . DS . $filename . '.' . $extension;

            $response = Curl::to($file['url'])
                ->withContentType('image/' . $extension)
                ->download($filePath);

            if (@is_array(getimagesize($filePath))) {
                $image = true;
            }

            if ($image) {
                $image = 'data:image/' . $extension . ';base64,' . base64_encode($response);
                try {
                    $imageData = $this->saveBase64Data($image, 'storage', Auth::user(), $saveParams);
                } catch (ImagickException $e) {
                    $imageData = null;
                    debugvars($e->getMessage(), ['trace' => $e->getTraceAsString()]);
                }
            }
        }

        return $imageData;
    }

    protected function saveBlobData($data)
    {
        return null;
    }

    /**
     * @param $imageData
     * @param string $folder
     * @param $user
     * @param array $saveParams
     * @param array $params
     * @return array|mixed|null
     * @throws ImagickException
     */
    protected function saveBase64Data($imageData, string $folder, $user, $saveParams = [], $params = [])
    {
        $config = collect(config('image.thumb.' . $folder))->map(function ($item) {
            return [
                'size' => $item['size'],
                'generateImage' => true,
                'watermark' => false,
                'text' => false,
                'color' => null
            ];
        });

        if (strstr($imageData, 'data:')) {

            $base64Img = preg_split('/,/', $imageData);
            $base64Img[1] = str_replace(' ', '+', $base64Img[1]);
            $binImage = base64_decode($base64Img[1]);

            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->buffer($binImage);

            if (!in_array($mimeType, array_values(config('netgamer.scoped_image_types')))) {
                return null;
            }

            $mimeTypeFromBin = preg_split('/;/', $base64Img[0]);

            if (isset($mimeTypeFromBin[0])) {
                $mimeTypeFromBin = preg_split('/:/', $mimeTypeFromBin[0]);
                if (isset($mimeTypeFromBin[1])) {
                    $mimeType = $mimeTypeFromBin[1];
                }
            }

            $mimeTypeParsed = preg_split('#/#', $mimeType);
            $extension = $mimeTypeParsed[1];

            if (preg_match('#svg#', $mimeTypeParsed[1])) {
                $extension = 'svg';
            }

            if ($extension == 'jpeg') {
                $extension = 'jpg';
                $mimeType = 'image/jpeg';
            }

            $fs = new Filesystem();

            $hash = generate_code(16, true);

            $defaultPath = StorageFile::STORAGE_PATH . $user->id . DS . $hash[0] .
                $hash[1] . DS . $hash[2] . $hash[3] . DS . $hash[4] . DS;

            $path = $defaultPath . $extension . DS;

            $root = Media::getImageRoot();

            $fullPath = $root . DS . $path;

            $newFilename = $hash . '.' . $extension;

            if (in_array($extension, ['png', 'bmp'])) {
                $path = $defaultPath . 'jpg' . DS;
                $fullPath = $root . DS . $path;
            }

            if (!file_exists($fullPath)) {
                $fs->makeDirectory($fullPath, 0755, true);
            }

            switch ($extension) {
                case 'png':
                    $png = imagecreatefromstring($binImage);
                    $whiteBack = imagecreatetruecolor(imagesx($png), imagesy($png));
                    $color = imagecolorallocatealpha($whiteBack, 0, 0, 0, 127);

                    imagefill($whiteBack, 0, 0, $color);
                    imagecopy($whiteBack, $png, 0, 0, 0, 0, imagesx($png), imagesy($png));
                    imagepng($whiteBack, $fullPath . $hash . '.png', 7);
                    imagedestroy($whiteBack);
                    imagedestroy($png);

                    $newFilename = $hash . '.png';
                    break;

                case 'jpg':
                    $jpg = imagecreatefromstring($binImage);
                    imagejpeg($jpg, $fullPath . $hash . '.' . $extension, 70);
                    imagedestroy($jpg);
                    break;

                case 'gif':

                    file_put_contents($fullPath . $newFilename, $binImage);

                    $image = new Imagick($fullPath . $newFilename);

                    try {
                        $image->optimizeImageLayers();
                    } catch (Exception $e) {
                        debugvars('GIF cannot be parsed');
                    }

                    $image->writeImages($fullPath . $newFilename, true);
                    $image->destroy();

                    break;

                default:
                    file_put_contents($fullPath . $newFilename, $binImage);
                    break;
            }

            $root = Media::getImageRoot();

            $storageFileData = [
                'user_id' => $user->id,
                'filename' => $newFilename,
                'type' => $mimeType,
                'size' => File::size($fullPath . $newFilename),
                'hash' => $hash,
                'extension' => $extension,
                'url' => $path,
                'path' => $root . DS . $path . $newFilename
            ];

            if (!empty($saveParams)) {
                $storageFileData += $saveParams;
            }

            $storageFile = StorageFile::create($storageFileData);

            $fullPathname = $this->updateThumbs($params, $newFilename, $fullPath . $newFilename);

            $imgData = $this->createThumbs($fullPathname, $config, $folder, null, $user);

            $imgData = self::addHash($imgData);

            $imgData['id'] = $storageFile->id;
            $imgData['title'] = $storageFile->title;
            $imgData['description'] = $storageFile->description;
            $imgData['url'] = getSchema() . $user->domain . $path . DS . $newFilename;

            $this->saveOriginal($imageData, $folder, $newFilename);

            return $imgData;
        }

        if (!empty($params['storageFile'])) {

            $filename = $params['storageFile']->filename;

            $fullPathname = $this->updateThumbs($params, $filename);

            $root = Media::getImageRoot();

            $thumbsPath = $root . DS . config('netgamer.upload_dir') .
                DS . 'storage' . DS . $folder . DS . 'thumbs' . DS;

            foreach ($config as $thumb) {
                $fullThumbPath = $thumbsPath . $thumb['size'][0] . 'x' . $thumb['size'][1] . DS . $filename;
                if (file_exists($fullThumbPath)) {
                    File::delete($fullThumbPath);
                }
            }

            if ($fullPathname) {
                $imgData = $this->createThumbs($fullPathname, $config, $folder, null, $user);

                $imgData = self::addHash($imgData);

                $imgData['id'] = $params['storageFile']->id;
                $imgData['title'] = $params['storageFile']->title;
                $imgData['description'] = $params['storageFile']->description;
                $imgData['url'] = $imgData['original'];
                return $imgData;
            }
        }

        return null;
    }

    public function updateThumbs($params, $newFilename, $fullPathname = null)
    {
        if (isset($params['file'])) {
            if (isset($params['file']['url_miniature']) && strstr($params['file']['url_miniature'], 'data:')) {
                $thumb = $params['file']['url_miniature'];
                $base64Thumb = preg_split('/\,/', $thumb);
                $base64Thumb[1] = str_replace(' ', '+', $base64Thumb[1]);
                $binImageThumb = base64_decode($base64Thumb[1]);
                $tmpPath = sys_get_temp_dir() . DS . $newFilename;
                file_put_contents($tmpPath, $binImageThumb);
                $fullPathname = $tmpPath;

                return $fullPathname;
            }
        }

        return $fullPathname;
    }

    public static function addHash($imgData)
    {
        foreach ($imgData as $key => $value) {
            if (preg_match('/thumb/', $key)) {

                $imgData[$key] = $value . '?' . generate_code(2, true);
            }
        }
        return $imgData;
    }

    public function liveResize()
    {

    }
}
