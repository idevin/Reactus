<?php

namespace App\Models;

use App\Contracts\Commentable;
use App\Contracts\Rating;
use App\Contracts\Rss;
use App\Contracts\SiteMap;
use App\Models\Rating as RatingModel;
use App\Traits\Announceable;
use App\Traits\Article as ArticleTrait;
use App\Traits\Media;
use Auth;
use Carbon\Carbon;
use Conner\Tagging\Taggable;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use JetBrains\PhpStorm\ArrayShape;
use Watson\Rememberable\Rememberable;


/**
 * Class Article
 *
 * @package App\Models
 * @property int $id
 * @property Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $title
 * @property int $status
 * @property \Illuminate\Support\Carbon $published_at
 * @property \Illuminate\Support\Carbon|null $unpublished_at
 * @property int $comments_cnt
 * @property int $views_cnt
 * @property int $likes_cnt
 * @property float $rating
 * @property int $author_id
 * @property int $section_id
 * @property int $site_id
 * @property \Illuminate\Support\Carbon|null $last_comment_at
 * @property int|null $last_comment_id
 * @property string|null $last_comment_author
 * @property array|null $settings
 * @property string $image
 * @property string|null $slug
 * @property int $draft
 * @property int $active
 * @property int $on_main
 * @property int $on_main_head
 * @property int|null $transfer_to_section
 * @property int $transfered
 * @property string|null $content_short
 * @property string $content
 * @property int $sort_order
 * @property int $sort_comments 1 - по рейтингу, 2 - по дате публикации
 * @property string|null $react_data
 * @property int $hide_author
 * @property int $show_article_rating
 * @property string|null $seo_title
 * @property string|null $seo_description
 * @property string|null $seo_h1
 * @property string|null $seo_breadcrumbs
 * @property int $rotate_slides
 * @property int $show_background
 * @property-read \Illuminate\Database\Eloquent\Collection|ArticleGroupArticle[] $articleGroupArticles
 * @property-read User $author
 * @property-read CommentArchive $commentArchive
 * @property-read \Illuminate\Database\Eloquent\Collection|Comment[] $comments
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
 * @property-read \Illuminate\Database\Eloquent\Collection $tags
 * @property mixed $thumbs
 * @property-read mixed $updated_at_formated
 * @property-read mixed $url
 * @property-read mixed $voted
 * @property-read \Illuminate\Database\Eloquent\Collection|ArticleStorageImage[] $images
 * @property-read \Illuminate\Database\Eloquent\Collection|LanguageObject[] $languageObjects
 * @property-read \Illuminate\Database\Eloquent\Collection|ArticleRevision[] $revisions
 * @property-read Section $section
 * @property-read Site $site
 * @property-read \Illuminate\Database\Eloquent\Collection|Tagged[] $tagged
 * @property-read Article $toArticle
 * @method static Builder|Article active()
 * @method static Builder|Article best($site_ids)
 * @method static Builder|Article bestOfDay()
 * @method static Builder|Article bestOfMonth()
 * @method static Builder|Article bestOfWeek()
 * @method static Builder|Article byAuthor($id)
 * @method static Builder|Article byNotSiteDomain($site)
 * @method static Builder|Article bySection($sectionId)
 * @method static Builder|Article bySite($siteId)
 * @method static Builder|Article bySites($sites)
 * @method static Builder|Article byUser($id)
 * @method static Builder|Article discussed($site_ids)
 * @method static bool|null forceDelete()
 * @method static Builder|Article getForRss($obSite)
 * @method static Builder|Article getSiteMapList(Site $obSite)
 * @method static Builder|Article latest($site_ids)
 * @method static Builder|Article newModelQuery()
 * @method static Builder|Article newQuery()
 * @method static Builder|Article onModeration()
 * @method static Builder|Article onlyTrashed()
 * @method static Builder|Article perPeriod($field, $dtFrom, $dtTo)
 * @method static Builder|Article popular($site_ids)
 * @method static Builder|Article published()
 * @method static Builder|Article query()
 * @method static Builder|Article recent($siteIds)
 * @method static bool|null restore()
 * @method static Builder|Article sort($sort, $dir)
 * @method static Builder|Article whereActive($value)
 * @method static Builder|Article whereAuthorId($value)
 * @method static Builder|Article whereCommentsCnt($value)
 * @method static Builder|Article whereContent($value)
 * @method static Builder|Article whereContentShort($value)
 * @method static Builder|Article whereCreatedAt($value)
 * @method static Builder|Article whereDeletedAt($value)
 * @method static Builder|Article whereDraft($value)
 * @method static Builder|Article whereHideAuthor($value)
 * @method static Builder|Article whereId($value)
 * @method static Builder|Article whereImage($value)
 * @method static Builder|Article whereLastCommentAt($value)
 * @method static Builder|Article whereLastCommentAuthor($value)
 * @method static Builder|Article whereLastCommentId($value)
 * @method static Builder|Article whereLikesCnt($value)
 * @method static Builder|Article whereOnMain($value)
 * @method static Builder|Article whereOnMainHead($value)
 * @method static Builder|Article wherePreviewHash($value)
 * @method static Builder|Article wherePublishedAt($value)
 * @method static Builder|Article whereRating($value)
 * @method static Builder|Article whereReactData($value)
 * @method static Builder|Article whereRotateSlides($value)
 * @method static Builder|Article whereSectionId($value)
 * @method static Builder|Article whereSeoBreadcrumbs($value)
 * @method static Builder|Article whereSeoDescription($value)
 * @method static Builder|Article whereSeoH1($value)
 * @method static Builder|Article whereSeoTitle($value)
 * @method static Builder|Article whereSettings($value)
 * @method static Builder|Article whereShowArticleRating($value)
 * @method static Builder|Article whereShowBackground($value)
 * @method static Builder|Article whereSiteId($value)
 * @method static Builder|Article whereSlug($value)
 * @method static Builder|Article whereSortComments($value)
 * @method static Builder|Article whereSortOrder($value)
 * @method static Builder|Article whereStatus($value)
 * @method static Builder|Article whereTitle($value)
 * @method static Builder|Article whereToArticleId($value)
 * @method static Builder|Article whereTransferToSection($value)
 * @method static Builder|Article whereTransfered($value)
 * @method static Builder|Article whereUnpublishedAt($value)
 * @method static Builder|Article whereUpdatedAt($value)
 * @method static Builder|Article whereViewsCnt($value)
 * @method static Builder|Article withAllTags($tagNames)
 * @method static Builder|Article withAnyTag($tagNames)
 * @method static Builder|Article withTrashed()
 * @method static Builder|Article withoutTags($tagNames)
 * @method static Builder|Article withoutTrashed()
 * @mixin Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|Announcement[] $announcements
 * @property-read int|null $announcements_count
 * @property-read int|null $article_group_articles_count
 * @property-read int|null $comments_count
 * @property-read int|null $images_count
 * @property-read int|null $language_objects_count
 * @property-read int|null $revisions_count
 * @property-read int|null $tagged_count
 * @method static Builder|Article announced($id, $objectClass, $modelClass)
 * @property-read mixed $announce_object
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Announcement[] $announces
 * @property-read int|null $announces_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ArticleStorageImage[] $storageImages
 * @property-read int|null $storage_images_count
 * @method static Builder|Article role($roles)
 */
class Article extends Commentable implements Rating, Rss, SiteMap
{
    use SoftDeletes;
    use Taggable;
    use Media;
    use Rememberable;
    use Announceable;
    use ArticleTrait;

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
    public string $rememberCacheTag = self::class;
    public $timestamps = true;
    public $articleGroup = null;
    public $dateFormat = 'Y-m-d H:i:s';
    public $appends = [
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
        'updated_at_formated',
        'images'
    ];
    protected $table = 'article';
    protected $dates = ['deleted_at', 'published_at', 'last_comment_at', 'unpublished_at'];
    protected $fillable = [
        'title', 'content', 'rating', 'views_cnt', 'comments_cnt', 'section_id', 'active', 'on_main',
        'author_id', 'site_id', 'settings', 'image', 'slug', 'draft', 'published_at', 'status',
        'on_main_head', 'last_comment_at', 'last_comment_id', 'last_comment_author',
        'likes_cnt', 'transfer_to_section', 'transfered', 'unpublished_at', 'content_short',
        'sort_order', 'sort_comments', 'react_data', 'hide_author', 'show_article_rating',
        'seo_title', 'seo_description', 'seo_h1', 'seo_breadcrumbs', 'rotate_slides', 'show_background', 'article_group'
    ];
    protected $attributes = [
        'draft' => false
    ];
    protected $connection = 'mysql';

    public static function getOther(Site $site, $limit, $field, $dir)
    {
        return self::published()
            ->where('site_id', '!=', $site->id)
            ->orderBy($field, $dir)
            ->take($limit)
            ->remember(config('app.remember_time'))
            ->get();
    }

    public static function getMore($site, $limit, $field, $dir, $without = [],
                                   $field2 = null, $dir2 = null, $filter = null, $args = null)
    {
        return self::more($site, $limit, $field, $dir, $without, $field2, $dir2, $filter, $args);
    }

    /**
     * @param string $for
     * @return array
     */
    public static function selectFields(string $for = 'ajax'): array
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

    public static function calculateRating($object)
    {
        $objects = RatingModel::where(['object_id' => $object->id, 'object' => get_class($object)])->get();
        $total = 0;

        foreach ($objects as $object) {
            $total += $object->rating_value;
        }

        return $total <> 0 ? ($total / count($objects)) : $total;
    }

    public function searchData(): array
    {
        return ['title' => $this->title];
    }

    public function getID(): int
    {
        return $this->id;
    }

    #[ArrayShape([self::STATUS_DRAFT => "string", self::STATUS_PUBLISHED => "string", self::STATUS_ON_MODERATION => "string", self::STATUS_ON_TRANSFER => "string"])]
    public function getStatusOptions(): array
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

    public function getClass(): string
    {
        return self::class;
    }

    public function getAttachedAttribute(): array
    {
        return [
            'video',
            'audio',
            'file',
            'favorite',
            'url'
        ];
    }

    public function getSortCommentsOptions(): array
    {
        return [
            static::SORT_BY_DATE => 'По дате',
            static::SORT_BY_RATING => 'По популярности',
        ];
    }

    public function getLastCommentUrlAttribute(): string
    {
        if (!empty($this->last_comment_id)) {
            $stringComment = '#c-' . $this->last_comment_id;
            return route_to_article($this) . $stringComment;
        } else {
            return '';
        }
    }

    public function getApiUrl($comment): string
    {
        if (!empty($comment)) {
            $stringComment = '#c-' . $comment->id;
            return $comment->object() ? route_to_article($comment->object()) . $stringComment : '';
        } else {
            return '';
        }
    }

    public function complains($id): Collection
    {
        $complains = Complain::query()->where('object_id', $id)->where('object', Article::class);

        return $complains->get();
    }

    public function getUrlAttribute(): string
    {
        return route_to_article($this, true);
    }

    public function getOriginAttribute(): array
    {
        $url = route_to_article($this, true);

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

    public function getHashIdAttribute(): string
    {
        return encrypt($this->id, false);
    }

    public function getTagsText(): string
    {
        $tags = $this->tags->pluck('name')->toArray();

        return count($tags) ? implode(', ', $tags) : '';
    }

    public function getPublishedAtAttribute($value)
    {
        return $value ? Carbon::parse($value)->toDateTimeString() : null;
    }

    public function setThumbsAttribute($value)
    {
        $this->attributes['thumbs'] = $value;
    }

    public function getImageUrlAttribute()
    {
        $thumbs = $this->getThumbsAttribute();
        $thumb = null;

        if (!empty($thumbs)) {
            $thumb = $thumbs['thumb1920x1080'];
        }

        return $thumb;
    }

    public function getThumbsAttribute(): array
    {
        $thumbs = [];

        $images = $this->storageImages;

        if ($images && count($images) > 0) {

            $storageFile = $images->random()->storageFile()->withTrashed()->first();
            if ($storageFile) {
                $thumbs = $storageFile->thumbs;
            }

        } else {

            foreach (config('image.thumb.article_slider') as $item) {

                $width = $item['size'][0];
                $height = $item['size'][1];
                $size = "{$width}x{$height}";

                $thumbs["thumb{$size}"] = $this->imageUrl($size, 'article_slider', $this->image);
            }

            $thumbs['original'] = $this->originalImageUrl('article_slider', $this->image, $this->author);
        }

        return $thumbs;
    }

    public function articleGroupArticles(): HasMany
    {
        return $this->hasMany(ArticleGroupArticle::class);
    }

    /**
     * @return mixed
     */
    public function storageImages(): mixed
    {
        return $this->hasMany(ArticleStorageImage::class)->with(['storageFile'])
            ->orderBy('sort_order')->withTrashed();
    }

    public function scopeBySites($query, array $sites)
    {
        return $query->whereIn('site_id', $sites);
    }

    public function scopeBySite($query, $siteId)
    {
        return $query->where('site_id', $siteId);
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

    public function getNameAttribute(): string
    {
        return $this->title;
    }

    public function getCreatedAtFormatedAttribute(): string|null
    {
        return datetime_format($this->published_at, false);
    }

    public function getUpdatedAtFormatedAttribute(): string|null
    {
        return datetime_format($this->updated_at, false);
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

    /**
     * @param Builder $query
     * @param array $siteIds
     * @return Builder
     */
    public function scopeRecent(Builder $query, array $siteIds): Builder
    {
        return $query->published()->active()->whereIn('site_id', $siteIds);
    }

    /**
     * @param Article $query
     * @param array $siteIds
     * @return Builder
     */
    public function scopePopular(Article $query, array $siteIds): Builder
    {
        return $query->published()
            ->where('views_cnt', '>', 0)
            ->whereIn('site_id', $siteIds)
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
     * @param Builder $query
     * @param $sort
     * @param $dir
     * @return mixed
     * @throws
     */
    public function scopeSort(Builder $query, $sort, $dir)
    {
        $sort = strtolower($sort);

        if (!in_array($sort, array_keys(self::$sortable))) {
            return $query;
        }

        $dir = strtolower($dir);
        if (!in_array($dir, self::$directions)) {
            return $query;
        }

        $query->orderBy(self::$sortable[$sort], $dir);

        return $query;
    }

    public function isDraft(): bool
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
        return ModerationAnswer::whereObjectId($this->id)->whereObject(Article::class)->first();
    }

    public function getContentArray()
    {
        return ['objectType' => Article::class, 'data' => '<b>статья:</b> <a target="_blank" href="' . route_to_article($this) . '">' . $this->title . '</a>'];
    }

    public function getNotFoundText()
    {
        return 'Статья не найдена...';
    }

    public function getArticleIdAttribute()
    {
        return $this->id;
    }

    public function commentArchive()
    {
        return $this->hasOne(CommentArchive::class);
    }

    public function revisions()
    {
        return $this->hasMany(ArticleRevision::class);
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

    public function scopeGetForRss($obQuery, $obSite)
    {
        if (empty($obSite)) {
            return $obQuery;
        }

        return $obQuery->where('site_id', $obSite->id)
            ->whereNull('deleted_at')->where('active', true)
            ->where('status', Article::STATUS_PUBLISHED);
    }

    public function getRSSItem(): string
    {
        $obSite = $this->site()->first();
        if (empty($obSite) || empty($obSite->domain)) {
            return '';
        }

        $res = '';
        $sLink = route('article.show', ['id' => $this->id, 'title' => $this->slug]);
        $res .= "<link>$sLink</link>";

        $obAuthor = $this->author()->first();
        $sAuthor = '';
        if (!empty($obAuthor) && !$this->hide_author && !empty($obAuthor->first_name)) {
            $sName = $obAuthor->first_name . ' ' . $obAuthor->last_name;
            if (!empty($sName) || $sName != ' ' || $sName != '  ') {
                $sAuthor = '<author>' . $sName . '</author>';
            }
        }

        $res .= $sAuthor;

        $obSection = $this->section()->first();
        $sSection = '';
        if (!empty($obSection)) {
            $sSection = '<category>' . $obSection->title . '</category>';
        }
        $res .= $sSection;
        $res .= '<pubDate>' . $this->updated_at . '</pubDate>';

        $sContentText = '<![CDATA[';
        $sContentText .= $this->getRssData();
        $sContentText .= ']]>';

        $res .= '<turbo:content>' . $sContentText . '</turbo:content>';
        return $res;
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class)->select(['id', 'domain', 'domain_id']);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    protected function getRssData(): string
    {
        $obHeader = '<header>';
        $obHeader .= '<h1>' . strip_tags($this->title) . '</h1>';

        $obHeader .= '</header>';

        $obPageSecondTitle = '<h2>' . $this->title . '</h2>';
        return $obHeader . $obPageSecondTitle . $this->content;
    }

    /**
     * @param Builder $query
     * @param Site $site
     * @return Collection
     */
    public function scopeGetSiteMapList(Builder $query, Site $site): Collection
    {
        return $query->where('site_id', $site->id)->get();
    }

    public function getSiteMapDATA(): array
    {
        if ($this->isStatusPublished()) {
            return [
                'loc' => route('article.show', ['id' => $this->id, 'title' => $this->slug]),
                'lastmod' => $this->updated_at->toDateString(),
                'changefreq' => 'monthly',
                'priority' => 1.0
            ];
        }
        return [];
    }

    public function isStatusPublished()
    {
        return (strtotime($this->published_at) <= strtotime('now') &&
            $this->active == 1 &&
            (int)$this->draft == Article::STATUS_DRAFT_OFF &&
            $this->status == Article::STATUS_PUBLISHED);
    }

    public function getContentShortAttribute()
    {
        $dots = null;

        if (self::$useShortContentDots == true && mb_strlen($this->attributes['content_short']) == 160) {
            $dots = '...';
        }

        return $this->attributes['content_short'] ? $this->attributes['content_short'] . $dots : null;
    }
}
