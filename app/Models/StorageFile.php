<?php

namespace App\Models;

use App\Traits\Media;
use App\Traits\Utils;
use Auth;
use Conner\Tagging\Taggable;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use ImagickException;

/**
 * App\Models\StorageFile
 *
 * @property int $id
 * @property int $user_id
 * @property string $filename
 * @property string $type
 * @property int $size
 * @property string $hash
 * @property string|null $url
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $favorite
 * @property int $recycle
 * @property string $extension
 * @property string $path
 * @property string|null $deleted_at
 * @property string|null $title
 * @property string|null $description
 * @property-read mixed $thumbs
 * @property-read Collection|StorageTag[] $tags
 * @property-read User $user
 * @method static Builder|StorageFile byUser($userId)
 * @method static Builder|StorageFile favorite()
 * @method static Builder|StorageFile favoriteCount()
 * @method static Builder|StorageFile files()
 * @method static bool|null forceDelete()
 * @method static Builder|StorageFile images()
 * @method static Builder|StorageFile newModelQuery()
 * @method static Builder|StorageFile newQuery()
 * @method static Builder|StorageFile notRecycled()
 * @method static \Illuminate\Database\Query\Builder|StorageFile onlyTrashed()
 * @method static Builder|StorageFile orderFavorite()
 * @method static Builder|StorageFile query()
 * @method static Builder|StorageFile recycle()
 * @method static Builder|StorageFile recycleCount()
 * @method static bool|null restore()
 * @method static Builder|StorageFile whereCreatedAt($value)
 * @method static Builder|StorageFile whereDeletedAt($value)
 * @method static Builder|StorageFile whereDescription($value)
 * @method static Builder|StorageFile whereExtension($value)
 * @method static Builder|StorageFile whereFavorite($value)
 * @method static Builder|StorageFile whereFilename($value)
 * @method static Builder|StorageFile whereHash($value)
 * @method static Builder|StorageFile whereId($value)
 * @method static Builder|StorageFile wherePath($value)
 * @method static Builder|StorageFile whereRecycle($value)
 * @method static Builder|StorageFile whereSize($value)
 * @method static Builder|StorageFile whereTitle($value)
 * @method static Builder|StorageFile whereType($value)
 * @method static Builder|StorageFile whereUpdatedAt($value)
 * @method static Builder|StorageFile whereUrl($value)
 * @method static Builder|StorageFile whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|StorageFile withTrashed()
 * @method static \Illuminate\Database\Query\Builder|StorageFile withoutTrashed()
 * @mixin Eloquent
 * @property-read int|null $tags_count
 * @property string|null $object_type
 * @property string|null $original_filename
 * @property array $tag_names
 * @property-read Collection|\Conner\Tagging\Model\Tagged[] $tagged
 * @property-read int|null $tagged_count
 * @method static Builder|StorageFile byTags($tags)
 * @method static Builder|StorageFile whereObjectType($value)
 * @method static Builder|StorageFile whereOriginalFilename($value)
 * @method static Builder|StorageFile withAllTags($tagNames)
 * @method static Builder|StorageFile withAnyTag($tagNames)
 * @method static Builder|StorageFile withoutTags($tagNames)
 * @property-read mixed $image_url
 * @property mixed $images
 */
class StorageFile extends Model
{
    use SoftDeletes;
    use Media;
    use Taggable;

    const CONTENT_TYPES = [
        'article', 'section'
    ];

    const STORAGE_PATH = DS . 'uploads' . DS . 'storage' . DS . 'files' . DS;

    const sort = [
        0 => 'title',
        1 => 'created_at',
        2 => 'size',
        3 => 'original_filename',
        4 => 'favorite',
        5 => 'id'
    ];

    const order = [
        0 => 'DESC',
        1 => 'ASC'
    ];

    const objectTypes = [
        'contact', 'link', 'event', 'file', 'image', 'audio', 'video', 'archive', 'text'
    ];
    public static array $whereSelect = [];
    protected $table = 'storage_file';
    protected $fillable = ['user_id', 'filename', 'type', 'size',
        'hash', 'favorite', 'recycle', 'url', 'extension', 'path', 'title', 'description', 'object_type',
        'original_filename'
    ];
    protected $appends = ['thumbs', 'tags'];
    protected $hidden = ['tagged'];

    /**
     * @param $id
     * @param $data
     * @return StorageFile|null
     */
    public static function updateById($id, $data): StorageFile|null
    {
        $storageFile = self::withTrashed()->find((int)$id);
        $storageFile?->update($data);

        return $storageFile;
    }

    /**
     * @return array
     */
    public static function getWhereSelect(): array
    {
        return self::$whereSelect;
    }

    public static function setWhereSelect(array $whereSelect)
    {
        self::$whereSelect = $whereSelect;
    }

    public function saveFile($file, $storageFile, $saveParams)
    {
        $imageData = [];

        if (strstr($file['url'], 'data:')) {

            try {
                $imageData = $this->saveBase64Data(
                    $file['url'],
                    'storage',
                    Auth::user(),
                    $saveParams,
                    ['file' => $file, 'storageFile' => $storageFile]
                );
            } catch (ImagickException $e) {
                debugvars($e->getMessage(), ['trace' => $e->getTraceAsString()]);
            }
        }

        if (strstr($file['url_miniature'], 'data:') && $file['url'] != $file['url_miniature']) {
            try {
                $imageData = $this->saveBase64Data(
                    $file['url_miniature'],
                    'storage',
                    Auth::user(),
                    $saveParams,
                    ['file' => $file, 'storageFile' => $storageFile]
                );
            } catch (ImagickException $e) {
                debugvars($e->getMessage(), ['trace' => $e->getTraceAsString()]);
            }
        }

        return $imageData;
    }

    /**
     * @param $file
     * @param $saveParams
     * @return array|null
     */
    public function saveFromUrl($file, $saveParams): ?array
    {
        return $this->saveUrl($file, $saveParams);
    }

    public function getThumbsAttribute(): array
    {
        $thumbs = [];

        if (in_array($this->extension, array_keys(config('netgamer.scoped_image_types')))) {

            foreach (config('image.thumb.storage') as $item) {

                $size = self::getSizes($item);

                $thumbs["thumb{$size}"] = $this->imageUrl($size, 'storage', $this->filename);
            }

            $thumbs['original'] = $this->originalImageUrl('storage', $this->filename, $this->user);
        }

        return $thumbs;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param Builder $query
     * @param $userId
     * @return Builder
     */
    public function scopeByUser(Builder $query, $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByTags($query, $tags)
    {
        $ids = [];
        $whereSelect = [];

        $tagData = Utils::parseTags($tags);

        if (!empty($tagData)) {
            $tagData = array_values($tagData);

            if (count($tagData) == 1) {
                $whereSelect[] = [
                    'AND' => $tagData[0]
                ];
            } else {
                foreach ($tagData as $tag) {
                    if (!empty($tag)) {
                        $whereSelect[] = [
                            'AND' => (int)$tag
                        ];
                    }
                }
            }

            $this->setWhereSelect($whereSelect);

            foreach ($whereSelect as $select) {
                foreach ($select['AND'] as $id) {
                    $ids[] = $id;
                }
            }
        }

        return $query->join('storage_file_tag', 'storage_file.id', 'storage_file_tag.storage_file_id')
            ->join('storage_tag', 'storage_tag.id', 'storage_file_tag.storage_tag_id')
            ->whereIn('storage_tag.id', $ids);
    }

    /**
     * @param Builder $query
     * @return array
     */
    public function scopeRecycleCount($query): array
    {
        $builder = $query->withTrashed()->whereNotNull('deleted_at');

        $files = $builder->get();

        $total = 0;
        if (!empty($files)) {
            foreach ($files as $file) {
                $total += $file->size;
            }
        }

        return ['count' => $builder->count(), 'total' => format_bytes($total)];
    }

    /**
     * @param Builder $query
     * @return int
     */
    public function scopeFavoriteCount(Builder $query): int
    {
        return $query->where(['favorite' => true])->count();
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeOrderFavorite($query): Builder
    {
        return $query->orderBy('favorite', 1)->orderBy('created_at', 'DESC');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeNotRecycled($query): Builder
    {
        return $query->where(['recycle' => false]);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeRecycle($query): Builder
    {
        return $query->where(['recycle' => true]);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeFavorite($query): Builder
    {
        return $query->where(['favorite' => true]);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeImages(Builder $query): Builder
    {
        $imageTypes = [];

        foreach (config('netgamer.scoped_image_types') as $type) {
            if (is_array($type)) {
                foreach ($type as $type2) {
                    $imageTypes[] = $type2;
                }
            }
            if (is_string($type)) {
                $imageTypes[] = $type;
            }
        }

        return $query->whereIn('type', $imageTypes);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeFiles($query): Builder
    {
        $ignoredTypes = $this->getIgnoredTypes();
        return $query->whereNotIn('type', $ignoredTypes);
    }

    private function getIgnoredTypes(): array
    {
        $config = config('netgamer');
        $mimeValues = [];

        foreach (array_keys($config) as $key) {
            if (strstr($key, 'scoped_')) {
                $mimeValues = array_merge($config[$key], $mimeValues);
            }
        }

        return $mimeValues;
    }
}