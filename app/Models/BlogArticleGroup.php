<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BlogArticleGroup
 *
 * @property int $id
 * @property string $name
 * @property int $user_id
 * @property int $site_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $article_id
 * @property-read \App\Models\BlogArticle $article
 * @property-read Collection|\App\Models\BlogArticleGroupArticle[] $articles
 * @property-read mixed $items
 * @property mixed $next
 * @property mixed $prev
 * @property-read mixed $url
 * @property-read \App\Models\Site $site
 * @property-read \App\Models\User $user
 * @method static Builder|\App\Models\BlogArticleGroup bySite($id)
 * @method static Builder|\App\Models\BlogArticleGroup byUser($id)
 * @method static Builder|\App\Models\BlogArticleGroup whereArticleId($value)
 * @method static Builder|\App\Models\BlogArticleGroup whereCreatedAt($value)
 * @method static Builder|\App\Models\BlogArticleGroup whereId($value)
 * @method static Builder|\App\Models\BlogArticleGroup whereName($value)
 * @method static Builder|\App\Models\BlogArticleGroup whereSiteId($value)
 * @method static Builder|\App\Models\BlogArticleGroup whereUpdatedAt($value)
 * @method static Builder|\App\Models\BlogArticleGroup whereUserId($value)
 * @mixin Eloquent
 * @method static Builder|\App\Models\BlogArticleGroup newModelQuery()
 * @method static Builder|\App\Models\BlogArticleGroup newQuery()
 * @method static Builder|\App\Models\BlogArticleGroup query()
 * @property-read int|null $articles_count
 */
class BlogArticleGroup extends Model
{
    public $timestamps = true;
    protected $table = 'blog_article_group';
    protected $fillable = ['article_id', 'name', 'site_id', 'user_id'];
    protected $appends = ['items', 'prev', 'next', 'url'];


    public function site()
    {
        return $this->belongsTo(BlogSite::class, 'site_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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
        return $this->hasMany(BlogArticleGroupArticle::class, 'article_group_id', 'id');
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
        return route_to_article($this->article, true);
    }
}
