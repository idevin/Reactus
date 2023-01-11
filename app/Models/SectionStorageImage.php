<?php

namespace App\Models;

use App\Traits\Media;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Models\SectionStorageImage
 *
 * @property int $id
 * @property int $section_id
 * @property int|null $storage_file_id
 * @property string|null $deleted_at
 * @property int $sort_order
 * @property-read Section $section
 * @property-read StorageFile|null $storageFile
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|SectionStorageImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SectionStorageImage newQuery()
 * @method static Builder|SectionStorageImage onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SectionStorageImage query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|SectionStorageImage whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SectionStorageImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SectionStorageImage whereSectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SectionStorageImage whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SectionStorageImage whereStorageFileId($value)
 * @method static Builder|SectionStorageImage withTrashed()
 * @method static Builder|SectionStorageImage withoutTrashed()
 * @mixin Eloquent
 * @property-read mixed $image_url
 * @property mixed $images
 * @property-read mixed $thumbs
 */
class SectionStorageImage extends Model
{
    use Media;
    use SoftDeletes;

    public $timestamps = false;

    protected $table = 'section_storage_image';

    protected $fillable = ['section_id', 'storage_file_id', 'sort_order'];

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function storageFile(): BelongsTo
    {
        return $this->belongsTo(StorageFile::class);
    }
}
