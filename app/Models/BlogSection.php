<?php

namespace App\Models;

use App\Contracts\Rating;
use App\Contracts\SiteMap;
use App\Contracts\SiteMapAggregator;
use App\Traits\Announceable;
use App\Traits\Media;
use App\Traits\Section;
use App\Traits\Utils;
use Auth;
use Baum\Node as BaumNode;
use Cache;
use Carbon\Carbon;
use Conner\Tagging\Taggable;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * Class Section
 *
 * @package App\Models
 * @property int $id
 * @property string $slug
 * @property Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property int $site_id
 * @property string $title
 * @property string|null $image
 * @property float $rating
 * @property int $articles_cnt
 * @property int $is_private
 * @property int $is_community
 * @property int $is_secret
 * @property int $members_cnt
 * @property int|null $parent_id
 * @property int|null $lft
 * @property int|null $rgt
 * @property int|null $depth
 * @property int $views_cnt
 * @property int|null $last_comment_id
 * @property string|null $last_article_date
 * @property string|null $last_comment_date
 * @property int $comments_cnt
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $sort_order
 * @property int|null $transfer_to_section
 * @property int $transfered
 * @property string|null $content_short
 * @property string|null $content
 * @property int|null $user_id
 * @property string|null $react_data
 * @property int $announce
 * @property string|null $settings
 * @property string|null $seo_title
 * @property string|null $seo_description
 * @property string|null $seo_h1
 * @property string|null $seo_breadcrumbs
 * @property array|null $filter_settings
 * @property array|null $sort_options
 * @property int|null $object_id
 * @property string|null $catalog_title
 * @property string|null $catalog_sort_by
 * @property int|null $catalog_sort_order
 * @property-read \Illuminate\Database\Eloquent\Collection|Article[] $articles
 * @property-read \Baum\Extensions\Eloquent\Collection|Section[] $children
 * @property-read mixed $attached
 * @property mixed $best_sub_sections
 * @property-read mixed $comments
 * @property-read mixed $created_at_formated
 * @property-read mixed $image_url
 * @property mixed $images
 * @property-read mixed $last_article
 * @property-read int|null $last_article_id
 * @property-read mixed $origin
 * @property-read mixed $section_id
 * @property-read mixed $section_user
 * @property-read mixed $subsections_cnt
 * @property mixed $tag_names
 * @property-read \Illuminate\Database\Eloquent\Collection $tags
 * @property mixed $thumbs
 * @property-read mixed $updated_at_formated
 * @property mixed $url
 * @property-read \Illuminate\Database\Eloquent\Collection|LanguageObject[] $languageObjects
 * @property-read Comment $lastComment
 * @property-read Section|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection|SectionRole[] $sectionRoles
 * @property-read \Illuminate\Database\Eloquent\Collection|SectionStorageImage[] $sectionStorageImages
 * @property-read \Illuminate\Database\Eloquent\Collection|SectionUser[] $sectionUsers
 * @property-read SectionSetting $setting
 * @property-read Site $site
 * @property-read \Illuminate\Database\Eloquent\Collection|Tagged[] $tagged
 * @property-read User|null $user
 * @method static Builder|Section bySite($site_id)
 * @method static Builder|Section depth($level)
 * @method static bool|null forceDelete()
 * @method static Builder|Section getSiteMapList(Site $obSite)
 * @method static Builder|BaumNode limitDepth($limit)
 * @method static Builder|Section newModelQuery()
 * @method static Builder|Section newQuery()
 * @method static Builder|Section onModeration()
 * @method static \Illuminate\Database\Query\Builder|Section onlyTrashed()
 * @method static Builder|Section published()
 * @method static Builder|Section query()
 * @method static bool|null restore()
 * @method static Builder|Section sort($sort, $dir)
 * @method static Builder|Section whereArticlesCnt($value)
 * @method static Builder|Section whereCatalogSortBy($value)
 * @method static Builder|Section whereCatalogSortOrder($value)
 * @method static Builder|Section whereCatalogTitle($value)
 * @method static Builder|Section whereCommentsCnt($value)
 * @method static Builder|Section whereContent($value)
 * @method static Builder|Section whereContentShort($value)
 * @method static Builder|Section whereCreatedAt($value)
 * @method static Builder|Section whereDeletedAt($value)
 * @method static Builder|Section whereDepth($value)
 * @method static Builder|Section whereFilterSettings($value)
 * @method static Builder|Section whereId($value)
 * @method static Builder|Section whereImage($value)
 * @method static Builder|Section whereIsCommunity($value)
 * @method static Builder|Section whereIsPrivate($value)
 * @method static Builder|Section whereIsSecret($value)
 * @method static Builder|Section whereLastArticleDate($value)
 * @method static Builder|Section whereLastCommentDate($value)
 * @method static Builder|Section whereLastCommentId($value)
 * @method static Builder|Section whereLft($value)
 * @method static Builder|Section whereMembersCnt($value)
 * @method static Builder|Section whereObjectId($value)
 * @method static Builder|Section whereParentId($value)
 * @method static Builder|Section wherePath($value)
 * @method static Builder|Section whereRating($value)
 * @method static Builder|Section whereReactData($value)
 * @method static Builder|Section whereRgt($value)
 * @method static Builder|Section whereSeoBreadcrumbs($value)
 * @method static Builder|Section whereSeoDescription($value)
 * @method static Builder|Section whereSeoH1($value)
 * @method static Builder|Section whereSeoTitle($value)
 * @method static Builder|Section whereSettings($value)
 * @method static Builder|Section whereSiteId($value)
 * @method static Builder|Section whereSlug($value)
 * @method static Builder|Section whereSortOptions($value)
 * @method static Builder|Section whereSortOrder($value)
 * @method static Builder|Section whereTitle($value)
 * @method static Builder|Section whereTransferToSection($value)
 * @method static Builder|Section whereTransfered($value)
 * @method static Builder|Section whereUpdatedAt($value)
 * @method static Builder|Section whereUserId($value)
 * @method static Builder|Section whereViewsCnt($value)
 * @method static Builder|Section withAllTags($tagNames)
 * @method static Builder|Section withAnyTag($tagNames)
 * @method static \Illuminate\Database\Query\Builder|Section withTrashed()
 * @method static Builder|BaumNode withoutNode($node)
 * @method static Builder|BaumNode withoutRoot()
 * @method static Builder|BaumNode withoutSelf()
 * @method static Builder|Section withoutTags($tagNames)
 * @method static \Illuminate\Database\Query\Builder|Section withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|BlogSection whereLastArticleId($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|Announcement[] $announcements
 * @property-read int|null $announcements_count
 * @property-read int|null $articles_count
 * @property-read int|null $children_count
 * @property-read int|null $language_objects_count
 * @property-read int|null $section_roles_count
 * @property-read int|null $section_storage_images_count
 * @property-read int|null $section_users_count
 * @property-read int|null $tagged_count
 * @method static Builder|BlogSection announced($id, $objectClass, $modelClass)
 * @property string $path
 * @property-read mixed $announce_object
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Announcement[] $announces
 * @property-read int|null $announces_count
 * @method static \Baum\Extensions\Eloquent\Collection|static[] all($columns = ['*'])
 * @method static \Baum\Extensions\Eloquent\Collection|static[] get($columns = ['*'])
 * @method static firstOrCreate(array $array)
 */
class BlogSection extends BaumNode implements Rating, SiteMap
{
    use Taggable;
    use SoftDeletes;
    use Media;
    use Announceable;
    use Section;
    use Utils;

    public static string $cacheKey = 'blog.section.path.';
    public static bool $useShortContentDots = true;
    public static array $sortOptions = [
        'rating' => 'Рейтинг',
        'title' => 'Заголовок',
        'created_at' => 'Дата публикации',
        'articles' => 'Количество статей',
        'last_article_date' => 'Дата последней статьи',
        'last_comment_date' => 'Дата последнего комментария'
    ];
    public static array $viewOptions = [
        '1' => 'Сетка',
        '0' => 'Список'
    ];
    public static array $limits = [
        '3' => '3',
        '6' => '6',
        '10' => '10',
        '20' => '20'
    ];
    public static array $directions = ['asc', 'desc'];
    public static array $sortable = [
        'title' => 'title',
        'articles' => 'articles_cnt',
        'rating' => 'rating',
        'members' => 'members_cnt',
        'created_at' => 'created_at',
        'last_article_date' => 'last_article_date',
        'last_comment_date' => 'last_comment_date'
    ];
    public static array $sortOptionsDefault = [
        'field' => 'id',
        'order' => 'desc',
        'limit' => 10,
        'view' => 0
    ];
    public $timestamps = true;
    protected $table = 'blog_section';
    protected $dates = ['deleted_at'];
    protected $connection = 'mysql';
    protected $casts = [
        'filter_settings' => 'array',
        'sort_options' => 'array'
    ];

    protected $fillable = ['content', 'title', 'slug', 'site_id', 'views_cnt', 'image', 'parent_id',
        'rating', 'last_comment_id', 'comments_cnt', 'deleted_at', 'sort_order', 'is_secret',
        'transfer_to_section', 'transfered', 'content_short', 'user_id', 'react_data',
        'last_article_date', 'show_rating', 'last_comment_date', 'seo_title', 'seo_description', 'seo_breadcrumbs',
        'filter_settings', 'sort_options', 'object_id', 'catalog_title', 'catalog_sort_by', 'catalog_sort_order'];

    protected $appends = [
        'url', 'thumbs', 'last_article_id',
        'origin', 'attached', 'last_article',
        'tags', 'subsections_cnt',
        'section_id', 'created_at_formated',
        'updated_at_formated', 'images', 'path'
    ];

    protected $parentColumn = 'parent_id';
    protected $leftColumn = 'lft';
    protected $rightColumn = 'rgt';
    protected $depthColumn = 'depth';
    protected $orderColumn = 'lft';
    protected $guarded = ['id', 'parent_id', 'lft', 'rgt', 'depth'];
    protected $scoped = ['site_id'];

    public static function getTreeOptions($site, $withRoot = true): array
    {
        return self::treeOptions($site, self::class, $withRoot);
    }

    public static function getSubSectionsArrayForSections($ids, $limit = 3)
    {
        $sections = static::query()->whereIn('parent_id', $ids)
            ->get()
            ->groupBy('parent_id')
            ->toArray();

        $arr = [];
        foreach ($sections as $id => $items) {
            $arr[$id] = collect($items)->sortByDesc('rating')->take($limit);
        }

        return $arr;
    }

    public static function selectOptions($notId = null, $empty = false, $notSiteId = null, $withRoot = true)
    {
        $data = BlogSection::with(['site' => function ($query) {
            return $query->thematic();
        }]);

        return self::optionsBuilder(self::class, $notId, $empty, $notSiteId, $withRoot);
    }

    /**
     * @return array
     */
    public static function ratingValues(): array
    {
        return array_values(range(1, 10));
    }


    public static function getUser()
    {
        $domainParts = preg_split('#\.#', env('DOMAIN'));
        $username = $domainParts[0];
        $user = User::query()->whereUsername($username)->first();
        return $user ? $user : null;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function (self $model) {
            $model->slug = slugify($model->title);
        });

        static::saving(function (self $model) {
            if ($model->isDirty('title')) {
                $model->slug = slugify($model->title);
            }
        });

    }

    public function getTagsText()
    {
        $tags = $this->tags->pluck('name')->toArray();

        return count($tags) ? implode(', ', $tags) : '';
    }


    public function getSectionUserAttribute()
    {
        return $this->sectionUsers()->get()->first();
    }

    public function sectionUsers()
    {
        return $this->hasMany(BlogSectionUser::class, 'user_id');
    }

    public function sectionRoles()
    {
        return $this->hasMany(SectionRole::class);
    }

    public function lastComment()
    {
        return $this->hasOne(BlogComment::class, 'id', 'last_comment_id');
    }

    public function getLastArticleAttribute()
    {
        $lastArticle = $this->lastArticle();

        if ($lastArticle) {
            return $lastArticle;
        } else {
            return null;
        }
    }

    public function lastArticle()
    {
        $lastArticle = BlogArticle::published()->where(['section_id' => $this->id])
            ->with(['author'])->orderBy('published_at', 'DESC')->limit(1)->first();

        return $lastArticle;
    }


    public function getUrlAttribute()
    {
        $url = route_to_section($this, true);
        $parentId = $this->parent_id;

        if ($parentId == null) {
            $prefix = getSchema();
            $url = $prefix . env('DOMAIN') . '/sections';
        }

        return $url;
    }

    public function setUrlAttribute($value)
    {
        $this->attributes['url'] = $value;
    }

    public function getOriginAttribute()
    {
        if ($this->parent_id == null) {
            $url = route('section.index', [], false);
        } else {
            $url = route_to_section($this, true);
        }

        return [
            'type' => 'section',
            'url' => $url,
            'text' => $this->title
        ];
    }

    public function sectionSetting()
    {
        return $this->setting();
    }

    public function setting()
    {
        return $this->hasOne(BlogSectionSetting::class, 'section_id');
    }

    public function getCommentsAttribute()
    {
        return [
            'last_user' => Auth::user(),
            'total' => rand(234, 12935),
            'created_at' => $this->created_at
        ];
    }

    public function setBestSubSectionsAttribute($value)
    {
        $this->attributes['best_sub_sections'] = $value;
    }

    public function getSubsectionsCntAttribute()
    {
        return count($this->children->where('is_secret', 0));
    }


    public function scopePublished($query)
    {
        return $query->whereIsSecret(0);
    }

    public function getBestSubSectionsAttribute()
    {
        return $this->attributes['best_sub_sections'];
    }

    public function descendantsWithSort($field, $order): Builder
    {
        return $this->getDescendantsWithSort($field, $order, self::$directions, self::$sortable);
    }

    public function scopeBySite($query, $siteId)
    {
        return $query->where('site_id', $siteId);
    }

    public function scopeOnModeration($query)
    {
        return $query->whereNotNull('transfer_to_section');
    }

    public function getMainDomain($port = false)
    {
        if ($this->depth <= 1) {
            return $this->site->domain . ($port == true ? getPort() : null);
        }

        return main_domain($this->site->domain) . ($port == true ? getPort() : null);
    }

    public function manager($site, $action)
    {
        $can = false;
        $user = Auth::user();

        if ($user) {

            $sectionUser = BlogSectionUser::where('user_id', $user->id)
                ->where('section_id', $this->id)->get()->first();

            if ($sectionUser && $user->can($action)) {
                $can = true;
            }
            if ($site->manager($user, $action)) {
                $can = true;
            }
        }

        return $can;
    }

    public function getSectionIdAttribute()
    {
        return $this->id;
    }

    public function getCreatedAtFormatedAttribute(): string|null
    {
        return datetime_format($this->created_at);
    }

    public function getUpdatedAtFormatedAttribute(): string|null
    {
        return datetime_format($this->created_at);
    }

    public function setTransferedAttribute($value)
    {
        $this->attributes['transfered'] = $value;
    }

    public function storageImages()
    {
        return $this->sectionStorageImages();
    }

    public function sectionStorageImages()
    {
        return $this->hasMany(BlogSectionStorageImage::class, 'section_id')->with(['storageFile'])->withTrashed();
    }

    public function languageObjects(): MorphMany
    {
        return $this->morphMany(LanguageObject::class, 'object');
    }

    /**
     * @param Builder $query
     * @param Site $site
     * @return Collection
     */
    public function scopeGetSiteMapList(Builder $query, Site $site): Collection
    {
        if (empty($site) || !isset($site->id)) {
            return $query->get();
        }

        return $query->where('site_id', $site->id)->get();
    }

    public function getSiteMapDATA(): array
    {
        $arResult = SiteMapAggregator::SITE_MAP_DATA_TEMPLATE;
        $arResult['loc'] = route('section.show', ['id' => $this->id, 'section' => $this->slug]);
        $arResult['lastmod'] = $this->updated_at->toDateString();

        return $arResult;
    }

    public function announcements(): MorphMany
    {
        return $this->morphMany(Announcement::class, 'object')->with('announce');
    }

    public function getPathAttribute()
    {
        $key = self::$cacheKey . $this->id;
        $path = Cache::get($key);

        if (empty($path)) {
            forget($key);
            $path = remember($key, function () {

                try {
                    $sections = $this->getAncestorsAndSelf();
                } catch (InvalidArgumentException $exception) {
                    $sections = [];
                }

                $path = '';
                if (count($sections) > 0) {
                    foreach ($sections as $section) {
                        $path .= DS . $section->slug;
                    }
                }

                return $path;
            });
        }

        return $path;
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
