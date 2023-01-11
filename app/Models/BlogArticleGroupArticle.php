<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BlogArticleGroupArticle
 *
 * @property int $id
 * @property int $article_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $name
 * @property int $article_group_id
 * @property int $sort_order
 * @property-read \App\Models\BlogArticle $article
 * @property-read \App\Models\BlogArticleGroup $article_group
 * @property-read mixed $url
 * @method static Builder|\App\Models\BlogArticleGroupArticle whereArticleGroupId($value)
 * @method static Builder|\App\Models\BlogArticleGroupArticle whereArticleId($value)
 * @method static Builder|\App\Models\BlogArticleGroupArticle whereCreatedAt($value)
 * @method static Builder|\App\Models\BlogArticleGroupArticle whereId($value)
 * @method static Builder|\App\Models\BlogArticleGroupArticle whereName($value)
 * @method static Builder|\App\Models\BlogArticleGroupArticle whereSortOrder($value)
 * @method static Builder|\App\Models\BlogArticleGroupArticle whereUpdatedAt($value)
 * @mixin Eloquent
 * @method static Builder|\App\Models\BlogArticleGroupArticle newModelQuery()
 * @method static Builder|\App\Models\BlogArticleGroupArticle newQuery()
 * @method static Builder|\App\Models\BlogArticleGroupArticle query()
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Permission[] $permissions
 * @property-read bool $voted
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @method static Builder|BlogArticleGroupArticle role($roles)
 */
class BlogArticleGroupArticle extends Model
{
    use \App\Traits\Article;
    protected $table = 'blog_article_group_article';
    protected $fillable = ['article_id', 'article_group_id', 'name', 'sort_order'];

    protected $appends = [
        'url'
    ];

    public function article_group()
    {
        return $this->belongsTo(BlogArticleGroup::class, 'article_id');
    }

    public function article()
    {
        return $this->hasOne(BlogArticle::class, 'id');
    }

}
