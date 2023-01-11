<?php

namespace App\Models;

use App\Models\Article as ArticleModel;
use App\Traits\Article as ArticleTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * App\Models\CommentArchive
 *
 * @property int $id
 * @property string $from_date
 * @property int $article_id
 * @property-read \App\Models\Article $article
 * @property-read mixed $comments_count
 * @method static Builder|\App\Models\CommentArchive newModelQuery()
 * @method static Builder|\App\Models\CommentArchive newQuery()
 * @method static Builder|\App\Models\CommentArchive query()
 * @method static Builder|\App\Models\CommentArchive whereArticleId($value)
 * @method static Builder|\App\Models\CommentArchive whereFromDate($value)
 * @method static Builder|\App\Models\CommentArchive whereId($value)
 * @mixin Eloquent
 * @property-read Collection|\App\Models\Permission[] $permissions
 * @property-read Collection|\App\Models\Role[] $roles
 * @method static Builder|\App\Models\CommentArchive role($roles)
 * @property-read int|null $permissions_count
 * @property-read int|null $roles_count
 * @property-read mixed $url
 * @property-read bool $voted
 */
class CommentArchive extends Model
{
    public $timestamps = false;
    use ArticleTrait;


    protected $connection = 'mysql';
    protected $table = 'comment_archive';

    protected $fillable = [
        'from_date', 'article_id'
    ];

    protected $appends = [
        'comments_count'
    ];

    public function article()
    {
        return $this->belongsTo(ArticleModel::class);
    }

    public function getCommentsCountAttribute()
    {
        $commentsCount = Comment::where('object_id', $this->article_id)
            ->where('created_at', '<', $this->from_date)
            ->where('object', ArticleModel::class)->get();

        return count($commentsCount);
    }
}