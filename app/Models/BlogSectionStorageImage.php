<?php

namespace App\Models;

use App\Traits\Media;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Models\BlogSectionStorageImage
 *
 * @property int $id
 * @property int $section_id
 * @property int|null $storage_file_id
 * @property string|null $deleted_at
 * @property int $sort_order
 * @property-read \App\Models\BlogSection $section
 * @property-read \App\Models\StorageFile|null $storageFile
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BlogSectionStorageImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BlogSectionStorageImage newQuery()
 * @method static Builder|\App\Models\BlogSectionStorageImage onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BlogSectionStorageImage query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BlogSectionStorageImage whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BlogSectionStorageImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BlogSectionStorageImage whereSectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BlogSectionStorageImage whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BlogSectionStorageImage whereStorageFileId($value)
 * @method static Builder|\App\Models\BlogSectionStorageImage withTrashed()
 * @method static Builder|\App\Models\BlogSectionStorageImage withoutTrashed()
 * @mixin Eloquent
 * @property-read mixed $image_url
 * @property mixed $images
 * @property-read mixed $thumbs
 */
class BlogSectionStorageImage extends Model
{
    use Media;
    use SoftDeletes;


    public $timestamps = false;

    protected $table = 'blog_section_storage_image';

    protected $fillable = ['section_id', 'storage_file_id', 'sort_order'];

    public function section()
    {
        return $this->belongsTo(BlogSection::class, 'section_id');
    }

    public function storageFile()
    {
        return $this->belongsTo(StorageFile::class);
    }
}
