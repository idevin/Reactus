<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\ProfileModuleArticle
 *
 * @property int $id
 * @property int $user_id
 * @property int $site_id
 * @property int $view 0 - анонсы, 1 - список
 * @property int $sort_by 0 - название, 1 - рейтинг, 2 - по дате публикации, 3 - по дате последнего комментария, 4 - по количеству комментариев, 5 - по количеству просмотров
 * @property int $sort_order 0 - по возрастанию, 1 - по убыванию
 * @property-read \App\Models\Site $site
 * @property-read \App\Models\User $user
 * @method static Builder|\App\Models\ProfileModuleArticle whereId($value)
 * @method static Builder|\App\Models\ProfileModuleArticle whereSiteId($value)
 * @method static Builder|\App\Models\ProfileModuleArticle whereSortBy($value)
 * @method static Builder|\App\Models\ProfileModuleArticle whereSortOrder($value)
 * @method static Builder|\App\Models\ProfileModuleArticle whereUserId($value)
 * @method static Builder|\App\Models\ProfileModuleArticle whereView($value)
 * @mixin Eloquent
 * @method static Builder|\App\Models\ProfileModuleArticle newModelQuery()
 * @method static Builder|\App\Models\ProfileModuleArticle newQuery()
 * @method static Builder|\App\Models\ProfileModuleArticle query()
 */
class ProfileModuleArticle extends Model
{
    public static $view = [
        0 => 'Анонсы',
        1 => 'Список'
    ];
    public static $sortBy = [
        0 => ['Название', 'title'],
        1 => ['Рейтинг', 'rating'],
        2 => ['Дата публикации', 'published_at'],
        3 => ['По дате последнего комментария', 'last_comment_at'],
        4 => ['По количеству комментариев', 'comments_cnt'],
        5 => ['По количеству просмотров', 'views_cnt'],
    ];
    public static $sortOrder = [
        0 => 'ASC',
        1 => 'DESC'
    ];
    public $timestamps = false;
    protected $table = 'profile_module_my_article';
    protected $fillable = [
        'user_id', 'site_id', 'view', 'sort_by', 'sort_order'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
