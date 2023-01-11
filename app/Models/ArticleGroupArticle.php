<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\ArticleGroupArticle
 *
 * @property int $id
 * @property int $article_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $article_group_id
 * @property string|null $name
 * @property int $sort_order
 * @property-read \App\Models\Article $article
 * @property-read \App\Models\ArticleGroup $article_group
 * @property-read mixed $url
 * @method static Builder|ArticleGroupArticle newModelQuery()
 * @method static Builder|ArticleGroupArticle newQuery()
 * @method static Builder|ArticleGroupArticle query()
 * @method static Builder|ArticleGroupArticle whereArticleGroupId($value)
 * @method static Builder|ArticleGroupArticle whereArticleId($value)
 * @method static Builder|ArticleGroupArticle whereCreatedAt($value)
 * @method static Builder|ArticleGroupArticle whereId($value)
 * @method static Builder|ArticleGroupArticle whereName($value)
 * @method static Builder|ArticleGroupArticle whereSortOrder($value)
 * @method static Builder|ArticleGroupArticle whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Permission[] $permissions
 * @property-read bool $voted
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @method static Builder|ArticleGroupArticle role($roles)
 */
class ArticleGroupArticle extends Model
{
    use \App\Traits\Article;
    protected $table = 'article_group_article';
    protected $fillable = ['article_id', 'article_group_id', 'name', 'sort_order'];

    protected $appends = [
        'url'
    ];

    public function article_group()
    {
        return $this->belongsTo(ArticleGroup::class);
    }

    public function article(): HasOne
    {
        return $this->hasOne(Article::class, 'id', 'article_id');
    }

}
