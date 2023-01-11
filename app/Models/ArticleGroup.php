<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\ArticleGroup
 *
 * @property int $id
 * @property string $name
 * @property int $user_id
 * @property int $site_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $article_id
 * @property-read \App\Models\Article $article
 * @property-read Collection|\App\Models\ArticleGroupArticle[] $articles
 * @property-read mixed $items
 * @property mixed $next
 * @property mixed $prev
 * @property-read mixed $url
 * @property-read \App\Models\Site $site
 * @property-read \App\Models\User $user
 * @method static Builder|ArticleGroup bySite($id)
 * @method static Builder|ArticleGroup byUser($id)
 * @method static Builder|ArticleGroup newModelQuery()
 * @method static Builder|ArticleGroup newQuery()
 * @method static Builder|ArticleGroup query()
 * @method static Builder|ArticleGroup whereArticleId($value)
 * @method static Builder|ArticleGroup whereCreatedAt($value)
 * @method static Builder|ArticleGroup whereId($value)
 * @method static Builder|ArticleGroup whereName($value)
 * @method static Builder|ArticleGroup whereSiteId($value)
 * @method static Builder|ArticleGroup whereUpdatedAt($value)
 * @method static Builder|ArticleGroup whereUserId($value)
 * @mixin Eloquent
 * @property-read int|null $articles_count
 */
class ArticleGroup extends Model
{
    public $timestamps = true;
    protected $table = 'article_group';
    protected $fillable = ['article_id', 'name', 'site_id', 'user_id'];
    protected $appends = ['items', 'prev', 'next', 'url'];


    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function scopeBySite($query, $id)
    {
        return $query->where([
            'site_id' => $id
        ]);
    }

    public function scopeByUser($query, $id)
    {
        return $query->where([
            'user_id' => $id
        ]);
    }

    public function getItemsAttribute()
    {
        return $this->articles()->orderBy('sort_order', 'asc')->get();
    }

    public function articles()
    {
        return $this->hasMany(ArticleGroupArticle::class, 'article_group_id', 'id');
    }

    public function getPrevAttribute()
    {
        return null;
    }

    public function getNextAttribute()
    {
        return null;
    }

    public function setPrevAttribute($data)
    {
        $this->attributes['prev'] = $data;
    }

    public function setNextAttribute($data)
    {
        $this->attributes['next'] = $data;
    }

    public function getUrlAttribute()
    {
        if ($this->article) {
            return route_to_article($this->article, true);
        } else {
            return null;
        }
    }
}
