<?php

namespace App\Models;

use App\Contracts\Commentable;
use App\Contracts\Rating;
use App\Traits\Announceable;
use App\Traits\Article;
use App\Traits\Media;
use Auth;
use Carbon\Carbon;
use Conner\Tagging\Taggable;
use Eloquent;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use JetBrains\PhpStorm\ArrayShape;
use Watson\Rememberable\Rememberable;

/**
 * App\Models\BlogArticle
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property string $react_data
 * @property string $content_short
 * @property int $status
 * @property int $active
 * @property int $draft
 * @property int $sort_order
 * @property int|null $sort_comments
 * @property int $comments_cnt
 * @property int $views_cnt
 * @property int $likes_cnt
 * @property float $rating
 * @property int|null $last_comment_id
 * @property int $author_id
 * @property int $section_id
 * @property int $site_id
 * @property string|null $last_comment_author
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property \Illuminate\Support\Carbon|null $unpublished_at
 * @property \Illuminate\Support\Carbon|null $last_comment_at
 * @property array|null $settings
 * @property string|null $image
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $rotate_slides
 * @property int $show_background
 * @property int $on_main
 * @property int $on_main_head
 * @property int $show_article_rating
 * @property string|null $seo_title
 * @property string|null $seo_description
 * @property string|null $seo_breadcrumbs
 * @property string|null $seo_h1
 * @property-read Collection|BlogArticleGroupArticle[] $articleGroupArticles
 * @property-read User $author
 * @property-read BlogCommentArchive $commentArchive
 * @property-read Collection|Comment[] $comments
 * @property-read mixed $announce
 * @property-read mixed $article_id
 * @property-read mixed $attached
 * @property-read mixed $created_at_formated
 * @property-read mixed $hash_id
 * @property-read mixed $image_url
 * @property-read mixed $last_comment
 * @property-read mixed $last_comment_url
 * @property-read mixed $name
 * @property-read mixed $origin
 * @property mixed $tag_names
 * @property-read Collection $tags
 * @property mixed $thumbs
 * @property-read mixed $updated_at_formated
 * @property-read mixed $url
 * @property-read mixed $voted
 * @property-read Collection|BlogArticleStorageImage[] $images
 * @property-read Collection|LanguageObject[] $languageObjects
 * @property-read Collection|BlogArticleRevision[] $revisions
 * @property-read BlogSection $section
 * @property-read Site $site
 * @property-read Collection|Tagged[] $tagged
 * @property-read BlogArticle $toArticle
 * @method static Builder|BlogArticle active()
 * @method static Builder|BlogArticle best($site_ids)
 * @method static Builder|BlogArticle bestOfDay()
 * @method static Builder|BlogArticle bestOfMonth()
 * @method static Builder|BlogArticle bestOfWeek()
 * @method static Builder|BlogArticle byAuthor($id)
 * @method static Builder|BlogArticle byNotSiteDomain($site)
 * @method static Builder|BlogArticle bySection($sectionId)
 * @method static Builder|BlogArticle bySite($siteId)
 * @method static Builder|BlogArticle bySites($sites)
 * @method static Builder|BlogArticle byUser($id)
 * @method static Builder|BlogArticle discussed($site_ids)
 * @method static bool|null forceDelete()
 * @method static Builder|BlogArticle latest($site_ids)
 * @method static Builder|BlogArticle newModelQuery()
 * @method static Builder|BlogArticle newQuery()
 * @method static Builder|BlogArticle onModeration()
 * @method static \Illuminate\Database\Query\Builder|BlogArticle onlyTrashed()
 * @method static Builder|BlogArticle perPeriod($field, $dtFrom, $dtTo)
 * @method static Builder|BlogArticle popular($site_ids)
 * @method static Builder|BlogArticle published()
 * @method static Builder|BlogArticle query()
 * @method static Builder|BlogArticle recent($siteIds)
 * @method static bool|null restore()
 * @method static Builder|BlogArticle sort($sort, $dir)
 * @method static Builder|BlogArticle whereActive($value)
 * @method static Builder|BlogArticle whereAuthorId($value)
 * @method static Builder|BlogArticle whereCommentsCnt($value)
 * @method static Builder|BlogArticle whereContent($value)
 * @method static Builder|BlogArticle whereContentShort($value)
 * @method static Builder|BlogArticle whereCreatedAt($value)
 * @method static Builder|BlogArticle whereDeletedAt($value)
 * @method static Builder|BlogArticle whereDraft($value)
 * @method static Builder|BlogArticle whereId($value)
 * @method static Builder|BlogArticle whereImage($value)
 * @method static Builder|BlogArticle whereLastCommentAt($value)
 * @method static Builder|BlogArticle whereLastCommentAuthor($value)
 * @method static Builder|BlogArticle whereLastCommentId($value)
 * @method static Builder|BlogArticle whereLikesCnt($value)
 * @method static Builder|BlogArticle whereOnMain($value)
 * @method static Builder|BlogArticle whereOnMainHead($value)
 * @method static Builder|BlogArticle wherePublishedAt($value)
 * @method static Builder|BlogArticle whereRating($value)
 * @method static Builder|BlogArticle whereReactData($value)
 * @method static Builder|BlogArticle whereRotateSlides($value)
 * @method static Builder|BlogArticle whereSectionId($value)
 * @method static Builder|BlogArticle whereSeoBreadcrumbs($value)
 * @method static Builder|BlogArticle whereSeoDescription($value)
 * @method static Builder|BlogArticle whereSeoH1($value)
 * @method static Builder|BlogArticle whereSeoTitle($value)
 * @method static Builder|BlogArticle whereSettings($value)
 * @method static Builder|BlogArticle whereShowArticleRating($value)
 * @method static Builder|BlogArticle whereShowBackground($value)
 * @method static Builder|BlogArticle whereSiteId($value)
 * @method static Builder|BlogArticle whereSlug($value)
 * @method static Builder|BlogArticle whereSortComments($value)
 * @method static Builder|BlogArticle whereSortOrder($value)
 * @method static Builder|BlogArticle whereStatus($value)
 * @method static Builder|BlogArticle whereTitle($value)
 * @method static Builder|BlogArticle whereUnpublishedAt($value)
 * @method static Builder|BlogArticle whereUpdatedAt($value)
 * @method static Builder|BlogArticle whereViewsCnt($value)
 * @method static Builder|BlogArticle withAllTags($tagNames)
 * @method static Builder|BlogArticle withAnyTag($tagNames)
 * @method static \Illuminate\Database\Query\Builder|BlogArticle withTrashed()
 * @method static Builder|BlogArticle withoutTags($tagNames)
 * @method static \Illuminate\Database\Query\Builder|BlogArticle withoutTrashed()
 * @mixin Eloquent
 * @property int $hide_author
 * @method static Builder|BlogArticle whereHideAuthor($value)
 * @property-read Collection|Announcement[] $announcements
 * @property-read int|null $announcements_count
 * @property-read int|null $article_group_articles_count
 * @property-read int|null $comments_count
 * @property-read int|null $images_count
 * @property-read int|null $language_objects_count
 * @property-read int|null $revisions_count
 * @property-read int|null $tagged_count
 * @method static Builder|BlogArticle announced($id, $objectClass, $modelClass)
 * @property-read mixed $announce_object
 * @property-read Collection|\App\Models\Announcement[] $announces
 * @property-read int|null $announces_count
 * @property-read Collection|\App\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read Collection|\App\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @method static Builder|BlogArticle role($roles)
 */
class BlogArticle extends Commentable implements Rating
{
    use SoftDeletes;
    use Taggable;
    use Media;
    use Rememberable;
    use Announceable;
    use Article;

    const STATUS_DRAFT = 1;
    const STATUS_DRAFT_OFF = 0;
    const STATUS_PUBLISHED = 0;
    const STATUS_ON_MODERATION = 2;
    const STATUS_ON_TRANSFER = 3;

    const SORT_BY_DATE = 0;
    const SORT_BY_RATING = 1;
    const COMMENTS_SORT_BY_RATING = 1;
    const COMMENTS_SORT_BY_DATE = 2;
    const defaultLimit = 100;

    public static bool $useShortContentDots = true;

    public static array $limits = [
        '3' => '3',
        '6' => '6',
        self::defaultLimit => self::defaultLimit,
        '20' => '20'
    ];

    public static array $adminLimits = [
        self::defaultLimit => self::defaultLimit,
        '20' => 20,
        '50' => 50
    ];

    public static array $sortComments = [

        self::COMMENTS_SORT_BY_RATING => [
            'alias' => 'rating',
            'name' => 'По рейтингу'
        ],
        self::COMMENTS_SORT_BY_DATE => [
            'alias' => 'created_at',
            'name' => 'По дате'
        ]
    ];
    public static array $sortOptions = [
        'rating' => 'Рейтинг',
        'views' => 'Кол-во просмотров',
        'comments' => 'Кол-во комментариев',
        'published_at' => 'Дата публикации',
        'commented_at' => 'Дата последнего комментария',
        'title' => 'Заголовок'
    ];
    public static array $viewOptions = [
        '1' => 'Сетка',
        '0' => 'Список'
    ];
    public static array $directions = ['asc', 'desc'];
    public static array $sortable = [
        'title' => 'title',
        'comments' => 'comments_cnt',
        'rating' => 'rating',
        'views' => 'views_cnt',
        'commented_at' => 'last_comment_at',
        'published_at' => 'published_at',
        'created_at' => 'created_at',
        'deleted_at' => 'deleted_at'
    ];
    public $timestamps = true;
    public $article_group = null;
    public $dateFormat = 'Y-m-d H:i:s';
    protected $table = 'blog_article';
    protected $dates = ['deleted_at', 'published_at', 'last_comment_at', 'unpublished_at'];
    protected $fillable = [
        'title', 'content', 'rating', 'views_cnt', 'comments_cnt', 'section_id', 'active', 'on_main',
        'author_id', 'site_id', 'settings', 'image', 'slug', 'draft', 'published_at', 'status',
        'on_main_head', 'last_comment_at', 'last_comment_id', 'last_comment_author',
        'likes_cnt', 'transfer_to_section', 'transfered', 'unpublished_at', 'content_short',
        'sort_order', 'sort_comments', 'react_data', '', 'show_article_rating',
        'seo_title', 'seo_description', 'seo_h1', 'seo_breadcrumbs', 'rotate_slides', 'show_background'
    ];
    protected $attributes = [
        'draft' => false
    ];
    protected $appends = [
        'url',
        'thumbs',
        'last_comment',
        'last_comment_url',
        'attached',
        'origin',
        'tags',
        'article_id',
        'voted',
        'name',
        'created_at_formated',
        'updated_at_formated'
    ];
    protected $connection = 'mysql';

    public static function getOther($site, $limit, $field, $dir)
    {
        return BlogArticle::published()
            ->where('site_id', '!=', $site->id)
            ->orderBy($field, $dir)
            ->take($limit)
            ->remember(config('app.remember_time'))
            ->get();
    }

    public static function getMore($site, $dir, $field, $limit = null, $without = [], $field2 = null,
                                   $dir2 = null, $filter = null, $args = null)
    {
        return self::more($site, $limit, $field, $dir, $without, $field2, $dir2, $filter, $args);
    }

    /**
     * @param string $for
     * @return array
     */
    public static function selectFields($for = 'ajax')
    {
        $fields = ['*'];

        if ($for == 'ajax') {
            $fields = ['id', 'title', 'rating', 'views_cnt', 'comments_cnt', 'likes_cnt', 'site_id', 'published_at'];
        }

        return $fields;
    }

    public static function ratingValues(): array
    {
        return array_values(range(1, 10));
    }


    #[ArrayShape(['title' => "string"])]
    public function searchData(): array
    {
        return ['title' => $this->title];
    }

    public function getID(): int
    {
        return $this->id;
    }

    public function getStatusOptions()
    {
        return [
            static::STATUS_DRAFT => 'Черновик',
            static::STATUS_PUBLISHED => 'Опубликовано',
            static::STATUS_ON_MODERATION => 'На модерации',
            static::STATUS_ON_TRANSFER => 'В состоянии переноса на другой ресурс'
        ];
    }

    /**
     * @param $complain
     * @return mixed
     */
    public function onUpdateComplain($complain)
    {
        $this->update([
            'status' => static::STATUS_ON_MODERATION,
            'draft' => 1
        ]);
        return $complain;
    }

    public function getClass()
    {
        return self::class;
    }

    public function getAttachedAttribute()
    {
        return [
            'video',
            'audio',
            'file',
            'favorite',
            'url'
        ];
    }

    public function getSortCommentsOptions()
    {
        return [
            static::SORT_BY_DATE => 'По дате',
            static::SORT_BY_RATING => 'По популярности',
        ];
    }

    public function getLastCommentUrlAttribute()
    {
        if (!empty($this->last_comment_id)) {
            $stringComment = '#c-' . $this->last_comment_id;
            return route_to_article($this) . $stringComment;
        } else {
            return null;
        }

    }

    public function getApiUrl($comment)
    {
        if (!empty($comment)) {
            $stringComment = '#c-' . $comment->id;
            return $comment->object() ? route_to_article($comment->object(), true, true) . $stringComment : null;
        } else {
            return null;
        }
    }

    public function complains($id)
    {
        $complains = Complain::where('object_id', $id)->where('object', Article::class);

        return $complains->get();
    }

    public function getUrlAttribute()
    {
        $url = route_to_article($this, true, true);

        return $url;
    }

    public function getOriginAttribute()
    {
        $url = route_to_article($this, true, true);

        return [
            'type' => 'article',
            'url' => $url,
            'text' => $this->title
        ];
    }

    public function lastComment()
    {
        return parent::lastComment();
    }

    public function getHashIdAttribute()
    {
        return encrypt($this->id, false);
    }

    public function getTagsText()
    {
        $tags = $this->tags->pluck('name')->toArray();

        return count($tags) ? implode(', ', $tags) : '';
    }

    public function getPublishedAtAttribute($value): string|null
    {
        return $value ? Carbon::parse($value)->toDateTimeString() : null;
    }

    public function setThumbsAttribute($value)
    {
        $this->attributes['thumbs'] = $value;
    }

    public function articleGroupArticles(): HasMany
    {
        return $this->hasMany(BlogArticleGroupArticle::class, 'article_id');
    }

    public function storageImages()
    {
        return $this->images();
    }

    public function images()
    {
        return $this->hasMany(BlogArticleStorageImage::class, 'article_id')->with(['storageFile'])
            ->orderBy('sort_order', 'asc')->withTrashed();
    }

    public function scopeBySites($query, array $sites)
    {
        return $query->whereIn('site_id', $sites);
    }

    public function scopeBySite($query, $siteId)
    {
        return $query->whereSiteId($siteId);
    }

    public function scopeByAuthor($query, $id)
    {
        return $this->scopeByUser($query, $id);
    }

    public function scopeByUser($query, $id)
    {
        return $query->where('author_id', $id);
    }

    public function scopeByNotSiteDomain($query, $site)
    {
        if ($site) {
            $root = $site->getRoot();

            $ids = $root->descendants()->pluck('id')->toArray();

            $ids[] = $root->id;

            return $query->whereNotIn('id', $ids);
        } else {
            return $query;
        }
    }

    public function scopeBySection($query, $sectionId)
    {
        return $query->where('section_id', $sectionId);
    }

    public function scopePublished($query)
    {
        $query->where('published_at', '<=', Carbon::now()->format($this->dateFormat));

        return $query;
    }

    public function getNameAttribute()
    {
        return $this->title;
    }

    public function getAnnounceAttribute()
    {
        return 0;
    }

    public function getCreatedAtFormatedAttribute(): string|null
    {
        return datetime_format($this->published_at);
    }

    public function getUpdatedAtFormatedAttribute(): string|null
    {
        return datetime_format($this->updated_at);
    }

    public function scopeBestOfDay($query)
    {
        $at = Carbon::now();
        $at->subDays(1);

        return $this->bestOf($query, $at);
    }

    protected function bestOf($query, Carbon $at)
    {
        return $query
            ->where('published_at', '>', $at->format($this->dateFormat))
            ->orderBy('rating', 'desc');
    }

    public function scopeBestOfMonth($query)
    {
        $at = Carbon::now();
        $at->subMonth();

        return $this->bestOf($query, $at);
    }

    public function scopeBestOfWeek($query)
    {
        $at = Carbon::now();
        $at->subDays(7);

        return $this->bestOf($query, $at);
    }

    public function setUrl($value)
    {
        $this->attributes['url'] = $value;
        return $this;
    }

    public function scopeLatest($query, array $site_ids)
    {
        return $query->published()
            ->whereIn('site_id', $site_ids)
            ->orderBy('published_at', 'desc');
    }

    public function scopeBest($query, array $site_ids)
    {
        return $query->published()
            ->whereIn('site_id', $site_ids)
            ->orderBy('rating', 'desc');
    }

    public function scopeRecent($query, array $siteIds)
    {
        return $query->published()
            ->whereIn('site_id', $siteIds);
    }

    /**
     * @param Article $query
     * @param array $site_ids
     * @return mixed
     */
    public function scopePopular($query, array $site_ids)
    {
        return $query->published()
            ->where('views_cnt', '>', 0)
            ->whereIn('site_id', $site_ids)
            ->orderBy('views_cnt', 'desc');
    }

    public function scopeOnModeration($query)
    {
        return $query->whereIn('status', [self::STATUS_ON_MODERATION, self::STATUS_ON_TRANSFER]);
    }

    /**
     * @param Article $query
     * @param array $site_ids
     * @return mixed
     */
    public function scopeDiscussed($query, array $site_ids)
    {
        return $query->published()
            ->whereIn('site_id', $site_ids)
            ->where('comments_cnt', '>', 0)
            ->orderBy('comments_cnt', 'desc');
    }

    /**
     * @param $query
     * @param $field
     * @param $dtFrom
     * @param $dtTo
     * @return mixed
     */
    public function scopePerPeriod($query, $field, $dtFrom, $dtTo)
    {
        return $query->whereBetween($field, [$dtFrom, $dtTo]);
    }

    /**
     * @param QueryBuilder $query
     * @param $sort
     * @param $dir
     * @return mixed
     * @throws
     */
    public function scopeSort($query, $sort, $dir)
    {
        $sort = strtolower($sort);

        if (!in_array($sort, array_keys(self::$sortable))) {
            throw new Exception('Invalid sorting parameter');
        }

        $dir = strtolower($dir);
        if (!in_array($dir, self::$directions)) {
            throw new Exception('Invalid sorting direction');
        }

        $query->orderBy(self::$sortable[$sort], $dir);

        return $query;
    }

    public function isDraft()
    {
        return (int)$this->draft == 1;
    }

    public function scopeActive($query)
    {
        $articleFilter = [
            'active' => 1,
            'draft' => self::STATUS_DRAFT_OFF,
            'status' => self::STATUS_PUBLISHED
        ];

        return $query->where($articleFilter);
    }

    public function isAllowComments()
    {
        $allowComments = 0;
        if ($this->settings && isset($this->settings['allow_comments'])) {
            $allowComments = $this->settings['allow_comments'];
        }

        return $allowComments;
    }

    public function isModerateComments()
    {
        $moderateComments = 0;
        if ($this->settings && isset($this->settings['moderate_comments'])) {
            $moderateComments = $this->settings['moderate_comments'];
        }

        return $moderateComments;
    }

    public function url()
    {
        return route_to_article($this);
    }

    public function moderationAnswer()
    {
        return ModerationAnswer::where(['object_id' => $this->id, 'object' => BlogArticle::class])->get()->first();
    }

    public function getContentArray()
    {
        return ['objectType' => BlogArticle::class, 'data' => '<b>статья:</b> <a target="_blank" href="' . route_to_article($this) . '">' . $this->title . '</a>'];
    }

    public function getNotFoundText()
    {
        return 'Статья не найдена...';
    }

    public function getArticleIdAttribute()
    {
        return $this->id;
    }


    public function commentArchive(): HasOne
    {
        return $this->hasOne(BlogCommentArchive::class, 'article_id');
    }

    public function revisions(): HasMany
    {
        return $this->hasMany(BlogArticleRevision::class, 'article_id');
    }

    public function languageObjects()
    {
        return $this->morphMany(LanguageObject::class, 'object');
    }

    public function languageObject()
    {
        return LanguageObject::where('object_id', $this->id)
            ->where('object_type', static::class)->first();
    }

    public function site()
    {
        return $this->belongsTo(BlogSite::class, 'site_id')->select(['id', 'domain']);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    public function section()
    {
        return $this->belongsTo(BlogSection::class, 'section_id');
    }

    public function isStatusPublished()
    {
        return (strtotime($this->published_at) <= strtotime('now') &&
            $this->active == 1 &&
            (int)$this->draft == BlogArticle::STATUS_DRAFT_OFF &&
            $this->status == BlogArticle::STATUS_PUBLISHED);
    }

    public function announcements()
    {
        return $this->morphMany(Announcement::class, 'object')->with('announce');
    }

    public function getContentShortAttribute(): string
    {
        $dots = null;

        if (self::$useShortContentDots == true && mb_strlen($this->attributes['content_short']) == 160) {
            $dots = '...';
        }

        return $this->attributes['content_short'] ? $this->attributes['content_short'] . $dots : '';
    }
}
