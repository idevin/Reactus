<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\SubscribeArticle
 *
 * @property int $id
 * @property int $user_id
 * @property int $article_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\Article $article
 * @property-read \App\Models\User $user
 * @method static Builder|\App\Models\SubscribeArticle whereArticleId($value)
 * @method static Builder|\App\Models\SubscribeArticle whereCreatedAt($value)
 * @method static Builder|\App\Models\SubscribeArticle whereId($value)
 * @method static Builder|\App\Models\SubscribeArticle whereUpdatedAt($value)
 * @method static Builder|\App\Models\SubscribeArticle whereUserId($value)
 * @mixin Eloquent
 * @method static Builder|\App\Models\SubscribeArticle newModelQuery()
 * @method static Builder|\App\Models\SubscribeArticle newQuery()
 * @method static Builder|\App\Models\SubscribeArticle query()
 */
class SubscribeArticle extends Model
{
    protected $connection = 'mysql';
    protected $table = 'subscribe_articles';
    protected $fillable = ['user_id', 'article_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}