<?php

namespace App\Models;

use App\Traits\Media;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Watson\Rememberable\Rememberable;

/**
 * App\Models\SiteStorageImage
 *
 * @property int $id
 * @property int $site_id
 * @property int|null $storage_file_id
 * @property string|null $deleted_at
 * @property int $type
 * @property int $sort_order
 * @property-read Site $site
 * @property-read StorageFile|null $storageFile
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|SiteStorageImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SiteStorageImage newQuery()
 * @method static Builder|SiteStorageImage onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SiteStorageImage query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|SiteStorageImage whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiteStorageImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiteStorageImage whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiteStorageImage whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiteStorageImage whereStorageFileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiteStorageImage whereType($value)
 * @method static Builder|SiteStorageImage withTrashed()
 * @method static Builder|SiteStorageImage withoutTrashed()
 * @mixin Eloquent
 * @property-read mixed $image_url
 * @property mixed $images
 * @property-read mixed $thumbs
 */
class SiteStorageImage extends Model
{
    use Media;
    use SoftDeletes;
    use Rememberable;

    const IMAGE = 0;
    const LOGO = 1;
    const FAVICON = 2;
    public $timestamps = false;
    public string $rememberCacheTag = self::class;

    protected $table = 'site_storage_image';
    protected $fillable = ['site_id', 'storage_file_id', 'type', 'sort_order'];

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function storageFile()
    {
        return $this->belongsTo(StorageFile::class)->withTrashed();
    }
}
