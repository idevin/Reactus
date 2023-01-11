<?php


namespace App\Models;

use App\Traits\Article as ArticleTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * App\Models\BlogCommentArchive
 *
 * @property int $id
 * @property string $from_date
 * @property int $article_id
 * @property-read \App\Models\BlogArticle $article
 * @property-read mixed $comments_count
 * @method static Builder|\App\Models\BlogCommentArchive whereArticleId($value)
 * @method static Builder|\App\Models\BlogCommentArchive whereFromDate($value)
 * @method static Builder|\App\Models\BlogCommentArchive whereId($value)
 * @mixin Eloquent
 * @method static Builder|\App\Models\BlogCommentArchive newModelQuery()
 * @method static Builder|\App\Models\BlogCommentArchive newQuery()
 * @method static Builder|\App\Models\BlogCommentArchive query()
 * @property-read Collection|\App\Models\Permission[] $permissions
 * @property-read Collection|\App\Models\Role[] $roles
 * @method static Builder|\App\Models\BlogCommentArchive role($roles)
 * @property-read int|null $permissions_count
 * @property-read int|null $roles_count
 * @property-read mixed $url
 * @property-read bool $voted
 */
class BlogCommentArchive extends Model
{
    public $timestamps = false;
    use ArticleTrait;

    protected $connection = 'mysql';
    protected $table = 'blog_comment_archive';


    protected $fillable = [
        'from_date', 'article_id'
    ];

    protected $appends = [
        'comments_count'
    ];

    public function article()
    {
        return $this->belongsTo(BlogArticle::class, 'article_id');
    }

    public function getCommentsCountAttribute()
    {
        $commentsCount = BlogComment::where('object_id', $this->article_id)
            ->where('created_at', '<', $this->from_date)
            ->where('object', BlogArticle::class)->get();

        return count($commentsCount);
    }
}