<?php

namespace App\Models;

use App\Traits\Media;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Models\ArticleStorageImage
 *
 * @property int $id
 * @property int|null $article_id
 * @property int|null $storage_file_id
 * @property string|null $deleted_at
 * @property int $sort_order
 * @property-read \App\Models\Article|null $article
 * @property-read \App\Models\StorageFile|null $storageFile
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleStorageImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleStorageImage newQuery()
 * @method static Builder|\App\Models\ArticleStorageImage onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleStorageImage query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleStorageImage whereArticleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleStorageImage whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleStorageImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleStorageImage whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleStorageImage whereStorageFileId($value)
 * @method static Builder|\App\Models\ArticleStorageImage withTrashed()
 * @method static Builder|\App\Models\ArticleStorageImage withoutTrashed()
 * @mixin Eloquent
 * @property-read mixed $image_url
 * @property mixed $images
 * @property-read mixed $thumbs
 */
class ArticleStorageImage extends Model
{
    use Media;
    use SoftDeletes;

    public $timestamps = false;

    protected $table = 'article_storage_image';

    protected $fillable = ['article_id', 'storage_file_id', 'sort_order'];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function storageFile(): BelongsTo
    {
        return $this->belongsTo(StorageFile::class);
    }
}
