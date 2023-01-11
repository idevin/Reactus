<?php

namespace App\Models;

use App\Traits\Media;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\BlogArticleStorageImage
 *
 * @property-read \App\Models\BlogArticle $article
 * @property-read \App\Models\StorageFile $storageFile
 * @method static bool|null forceDelete()
 * @method static Builder|\App\Models\BlogArticleStorageImage newModelQuery()
 * @method static Builder|\App\Models\BlogArticleStorageImage newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BlogArticleStorageImage onlyTrashed()
 * @method static Builder|\App\Models\BlogArticleStorageImage query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BlogArticleStorageImage withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BlogArticleStorageImage withoutTrashed()
 * @mixin Eloquent
 * @property int $id
 * @property int $article_id
 * @property int|null $storage_file_id
 * @property string|null $deleted_at
 * @property int $sort_order
 * @method static Builder|\App\Models\BlogArticleStorageImage whereArticleId($value)
 * @method static Builder|\App\Models\BlogArticleStorageImage whereDeletedAt($value)
 * @method static Builder|\App\Models\BlogArticleStorageImage whereId($value)
 * @method static Builder|\App\Models\BlogArticleStorageImage whereSortOrder($value)
 * @method static Builder|\App\Models\BlogArticleStorageImage whereStorageFileId($value)
 * @property-read mixed $image_url
 * @property mixed $images
 * @property-read mixed $thumbs
 */
class BlogArticleStorageImage extends Model
{
    use Media;
    use SoftDeletes;


    public $timestamps = false;

    protected $table = 'blog_article_storage_image';

    protected $fillable = ['article_id', 'storage_file_id', 'sort_order'];

    public function article()
    {
        return $this->belongsTo(BlogArticle::class, 'article_id');
    }

    public function storageFile()
    {
        return $this->belongsTo(StorageFile::class);
    }
}
