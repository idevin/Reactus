<?php

namespace App\Models;

use App\Helpers\Deployer\Classes\Deployer;
use App\Traits\Media;
use App\Traits\Site as SiteTrait;
use App\Traits\Utils;
use Auth;
use Baum\Node as BaumNode;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Session;

/**
 * Class Site
 *
 * @package App\Models
 * @property int $id
 * @property Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $domain
 * @property string $title
 * @property string|null $content
 * @property string|null $image
 * @property int|null $parent_id
 * @property int|null $lft
 * @property int|null $rgt
 * @property int|null $depth
 * @property int|null $domain_id
 * @property int $rating
 * @property string|null $header
 * @property string|null $header_home
 * @property string|null $logo
 * @property string|null $site_header
 * @property string|null $slogan
 * @property string|null $favicon
 * @property string|null $facebook_url
 * @property string|null $vk_url
 * @property string|null $twitter_url
 * @property string|null $ok_url
 * @property string|null $instagram_url
 * @property string|null $copyright
 * @property int $template_id
 * @property int|null $user_id
 * @property array|null $address
 * @property string|null $work_hours
 * @property string|null $email
 * @property string|null $sections_description
 * @property string|null $articles_description
 * @property int|null $filter_articles
 * @property string|null $filter_articles_sort
 * @property string|null $filter_articles_sort_direction
 * @property int|null $filter_sections
 * @property string|null $filter_sections_sort
 * @property string|null $filter_sections_sort_direction
 * @property int|null $filter_articles_view
 * @property int|null $filter_sections_view
 * @property int|null $articles_limit
 * @property int|null $sections_limit
 * @property array|null $phone
 * @property int|null $template_scheme_id
 * @property string|null $default_color
 * @property int $archive
 * @property int $show_article_rating
 * @property int $show_section_rating
 * @property int $hide_article_author_inside
 * @property int $show_article_author
 * @property int $hide_section_tags
 * @property int $breadcrumbs
 * @property int $breadcrumbs_position
 * @property int $repeat_animation
 * @property string|null $jivosite
 * @property int $show_in_pages
 * @property int $show_in_about_page
 * @property string|null $text
 * @property int|null $feedback_id
 * @property string|null $coords
 * @property-read Collection|Article[] $articles
 * @property-read \Baum\Extensions\Eloquent\Collection|Site[] $children
 * @property-read Collection|Comment[] $comments
 * @property-read Collection|Feedback[] $feedback
 * @property-read Collection|FieldUserValue[] $field_user_values
 * @property-read Collection|Field[] $fields
 * @property-read mixed $language
 * @property-read mixed $site_id
 * @property mixed $site_preview
 * @property-read mixed $url
 * @property-read Domain $host
 * @property-read Collection|SiteStorageImage[] $images
 * @property-read Collection|Menu[] $menu
 * @property-read Collection|News[] $news
 * @property-read Site|null $parent
 * @property-read \Baum\Extensions\Eloquent\Collection|Section[] $sections
 * @property-read Domain|null $siteDomain
 * @property-read Collection|SiteUser[] $siteUsers
 * @property-read Collection|SiteStorageImage[] $storageImages
 * @property-read BillingSubscription $subscription
 * @property-read Template $template
 * @property-read TemplateScheme|null $templateScheme
 * @property-read User|null $user
 * @property-read Collection|SiteUser[] $users
 * @method static bool|null forceDelete()
 * @method static Builder|BaumNode limitDepth($limit)
 * @method static Builder|Site newModelQuery()
 * @method static Builder|Site newQuery()
 * @method static \Illuminate\Database\Query\Builder|Site onlyTrashed()
 * @method static Builder|Site query()
 * @method static bool|null restore()
 * @method static Builder|Site sort($sort, $dir)
 * @method static Builder|Site thematic()
 * @method static Builder|Site whereAddress($value)
 * @method static Builder|Site whereArchive($value)
 * @method static Builder|Site whereArticlesDescription($value)
 * @method static Builder|Site whereArticlesLimit($value)
 * @method static Builder|Site whereBreadcrumbs($value)
 * @method static Builder|Site whereBreadcrumbsPosition($value)
 * @method static Builder|Site whereContent($value)
 * @method static Builder|Site whereCoords($value)
 * @method static Builder|Site whereCopyright($value)
 * @method static Builder|Site whereCreatedAt($value)
 * @method static Builder|Site whereDefaultColor($value)
 * @method static Builder|Site whereDeletedAt($value)
 * @method static Builder|Site whereDepth($value)
 * @method static Builder|Site whereDomain($value)
 * @method static Builder|Site whereDomainId($value)
 * @method static Builder|Site whereEmail($value)
 * @method static Builder|Site whereFacebookUrl($value)
 * @method static Builder|Site whereFavicon($value)
 * @method static Builder|Site whereFeedbackId($value)
 * @method static Builder|Site whereFilterArticles($value)
 * @method static Builder|Site whereFilterArticlesSort($value)
 * @method static Builder|Site whereFilterArticlesSortDirection($value)
 * @method static Builder|Site whereFilterArticlesView($value)
 * @method static Builder|Site whereFilterSections($value)
 * @method static Builder|Site whereFilterSectionsSort($value)
 * @method static Builder|Site whereFilterSectionsSortDirection($value)
 * @method static Builder|Site whereFilterSectionsView($value)
 * @method static Builder|Site whereHeader($value)
 * @method static Builder|Site whereHeaderHome($value)
 * @method static Builder|Site whereHideArticleAuthorInside($value)
 * @method static Builder|Site whereHideSectionTags($value)
 * @method static Builder|Site whereId($value)
 * @method static Builder|Site whereImage($value)
 * @method static Builder|Site whereInstagramUrl($value)
 * @method static Builder|Site whereJivosite($value)
 * @method static Builder|Site whereLft($value)
 * @method static Builder|Site whereLogo($value)
 * @method static Builder|Site whereOkUrl($value)
 * @method static Builder|Site whereParentId($value)
 * @method static Builder|Site wherePhone($value)
 * @method static Builder|Site whereRating($value)
 * @method static Builder|Site whereRepeatAnimation($value)
 * @method static Builder|Site whereRgt($value)
 * @method static Builder|Site whereSectionsDescription($value)
 * @method static Builder|Site whereSectionsLimit($value)
 * @method static Builder|Site whereShowArticleAuthor($value)
 * @method static Builder|Site whereShowArticleRating($value)
 * @method static Builder|Site whereShowInAboutPage($value)
 * @method static Builder|Site whereShowInPages($value)
 * @method static Builder|Site whereShowSectionRating($value)
 * @method static Builder|Site whereSiteHeader($value)
 * @method static Builder|Site whereSlogan($value)
 * @method static Builder|Site whereTemplateId($value)
 * @method static Builder|Site whereTemplateSchemeId($value)
 * @method static Builder|Site whereText($value)
 * @method static Builder|Site whereTitle($value)
 * @method static Builder|Site whereTwitterUrl($value)
 * @method static Builder|Site whereUpdatedAt($value)
 * @method static Builder|Site whereUserId($value)
 * @method static Builder|Site whereVkUrl($value)
 * @method static Builder|Site whereWorkHours($value)
 * @method static \Illuminate\Database\Query\Builder|Site withTrashed()
 * @method static Builder|BaumNode withoutNode($node)
 * @method static Builder|BaumNode withoutRoot()
 * @method static Builder|BaumNode withoutSelf()
 * @method static \Illuminate\Database\Query\Builder|Site withoutTrashed()
 * @mixin Eloquent
 * @property-read Collection|FeedbackRecipient[] $feedbackRecipients
 * @property-read int|null $articles_count
 * @property-read int|null $children_count
 * @property-read int|null $comments_count
 * @property-read int|null $feedback_count
 * @property-read int|null $feedback_recipients_count
 * @property-read int|null $field_user_values_count
 * @property-read int|null $fields_count
 * @property-read int|null $images_count
 * @property-read int|null $menu_count
 * @property-read int|null $news_count
 * @property-read int|null $sections_count
 * @property-read int|null $site_users_count
 * @property-read int|null $storage_images_count
 * @property-read int|null $users_count
 * @property int $views
 * @property string|null $captcha_hash
 * @property-read Collection|UserOrder[] $userOrders
 * @property-read int|null $user_orders_count
 * @method static Builder|Site whereCaptchaHash($value)
 * @method static Builder|Site whereViews($value)
 * @property string|null $recaptcha
 * @property int $hidden
 * @property string|null $menu_options
 * @property string|null $userbar_options
 * @property int $disable_indexing
 * @property string|null $head_tags
 * @property string|null $breadcrumbs_options
 * @property mixed $site_logo
 * @property \App\Models\Setting|null $setting
 * @method static \Baum\Extensions\Eloquent\Collection|static[] all($columns = ['*'])
 * @method static \Baum\Extensions\Eloquent\Collection|static[] get($columns = ['*'])
 * @method static Builder|Site whereBreadcrumbsOptions($value)
 * @method static Builder|Site whereDisableIndexing($value)
 * @method static Builder|Site whereHeadTags($value)
 * @method static Builder|Site whereHidden($value)
 * @method static Builder|Site whereMenuOptions($value)
 * @method static Builder|Site whereRecaptcha($value)
 * @method static Builder|Site whereUserbarOptions($value)
 * @method static firstOrCreate(array $array, array $array2)
 * @method static create(array $array)
 * @property-read mixed $image_url
 * @property-read mixed $thumbs
 */
class Site extends BaumNode
{
    use SoftDeletes;
    use Media;
    use \App\Traits\Domain;
    use SiteTrait;
    use Utils;

    public static array $breadcrumbsPosition = [
        0 => 'Слева',
        1 => 'По центру',
        2 => 'Справа'
    ];
    public static array $tree = [];
    public $timestamps = true;
    protected $table = 'site';
    protected $dates = ['deleted_at'];
    protected $appends = ['url', 'site_id', 'site_preview', 'language', 'logo'];
    protected array $sortable = [
        'title' => 'title',
        'rating' => 'rating',
        'published-at' => 'created_at',
        'id', 'domain'
    ];
    protected $fillable = [
        'slogan', 'facebook_url', 'favicon', 'vk_url', 'twitter_url', 'instagram_url', 'phone',
        'title', 'header', 'header_home', 'ok_url', 'copyright', 'template_id',
        'user_id', 'work_hours', 'address', 'domain', 'id', 'email', 'articles_limit', 'sections_limit',
        'sections_description', 'articles_description', 'filter_articles', 'template_scheme_id',
        'filter_articles_sort', 'filter_articles_sort_direction', 'filter_sections',
        'filter_sections_sort', 'filter_sections_sort_direction', 'filter_articles_view',
        'filter_sections_view', 'parent_id', 'default_color', 'image', 'logo', 'content',
        'domain_id', 'archive', 'show_article_rating', 'show_section_rating',
        'hide_article_author_inside', 'show_article_author', 'site_header', 'hide_section_tags',
        'breadcrumbs', 'breadcrumbs_position', 'jivosite', 'show_in_pages', 'show_in_about_page', 'text',
        'feedback_id', 'coords', 'views', 'recaptcha', 'hidden', 'disable_indexing', 'head_tags', 'menu_options',
        'breadcrumbs_options'
    ];
    protected array $directions = ['asc', 'desc'];

    protected $casts = [
        'phone' => 'json',
        'address' => 'json'
    ];

    public static function getTreeOptions($item = null, $withEmptyValue = false, $withRoot = true): array
    {
        if ($withEmptyValue) {
            self::$tree[''] = 'Выберите сайт...';
        }

        if (!$item) {
            $item = static::roots()->get();

            if ($withRoot) {
                foreach ($item as $i) {
                    self::$tree[$i->id] = idnToUtf8($i->domain);
                    $items = $i->getDescendants()->toHierarchy();
                    self::getTree($items);
                }
            }
        }

        foreach ($item as $j) {
            $items = $j->getDescendants()->toHierarchy();
            self::getTree($items);
        }

        return self::$tree;
    }

    public static function getTree($items = null)
    {
        if (count($items) > 0) {
            $items = $items->map(function ($item) {
                return ($item->siteDomain && !in_array($item->siteDomain->domain_type,
                        [Domain::DOMAIN_TYPE_PERSONAL, Domain::DOMAIN_TYPE_SYSTEM])) ? $item : null;
            })->filter();

            foreach ($items as $item) {

                self::$tree[$item->id] = str_repeat('&nbsp;', abs($item->depth * 3)) .
                    str_repeat('&#8735;', round($item->depth / ($item->depth + 1))) . idnToUtf8($item->domain);

                if (count($item->children) > 0) {
                    self::getTree($item->children);
                }
            }
        }
    }

    public static function selectOptions($notId = null, $empty = false): array
    {
        $data = Site::query()->orderBy('domain', 'ASC');

        if ($notId) {
            $data = $data->whereNotIn('id', [$notId]);
        }

        $data = $data->get();

        if ($empty == true) {
            $allData = [null => 'Выберите сайт...'];
        } else {
            $allData = [];
        }

        foreach ($data as $object) {
            $allData[$object->id] = idnToUtf8($object->domain);
        }

        return $allData;
    }

    /**
     * @param null $section
     * @return Site $site
     */
    public static function setBySection($section = null): Site
    {
        $siteAsSection = null;
        $site = get_site();

        if ($section) {
            $siteAsSection = SiteSection::check($section->id);
        }

        if (!empty($siteAsSection)) {
            $site = $siteAsSection->site;
            Session::put(['siteAsSection' => $siteAsSection]);
        } else {
            Session::remove('siteAsSection');
        }

        return $site;
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(SiteUser::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function setting(): HasOne
    {
        return $this->hasOne(Setting::class);
    }

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class);
    }

    public function userOrders(): HasMany
    {
        return $this->hasMany(UserOrder::class);
    }

    public function menu(): HasMany
    {
        return $this->hasMany(Menu::class);
    }

    public function templateScheme(): BelongsTo
    {
        return $this->belongsTo(TemplateScheme::class);
    }

    public function user(): BelongsTo
    {
        $this->setConnection('mysqlu');
        return $this->belongsTo(User::class);
    }

    public function host(): BelongsTo
    {
        return $this->belongsTo(Domain::class);
    }

    public function fields(): HasMany
    {
        return $this->hasMany(Field::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(SiteStorageImage::class);
    }

    public function feedback(): HasMany
    {
        return $this->hasMany(Feedback::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function siteDomain(): BelongsTo
    {
        $this->setConnection('mysql');
        return $this->belongsTo(Domain::class, 'domain_id');
    }

    public function field_user_values(): HasMany
    {
        return $this->hasMany(FieldUserValue::class);
    }

    public function descendantsWithSort($field, $order): Builder
    {
        return $this->getDescendantsWithSort($field, $order, $this->directions, $this->sortable);
    }

    public function getUrlAttribute(): string
    {
        return route_to_site($this);
    }

    public function getLogoAttribute(): array
    {
        return $this->originalLogo();
    }

    public function originalLogo(): array
    {
        return self::getSiteMedia($this);
    }

    public function getSiteLogoAttribute()
    {
        $logo = $this->originalLogo();
        return $logo['thumbs'] ?? $logo['thumbs']['thumb280x157'];
    }

    public function originalSiteHeader(): array
    {
        $images = SiteStorageImage::whereSiteId($this->id)->whereType(SiteStorageImage::IMAGE)
            ->orderBy('sort_order')->get();

        return self::getImages($images);
    }

    public static function getImages($images)
    {
        $data = [];

        if ($images && count($images) > 0) {

            $images->each(function ($image) use (&$data) {

                if ($image->storageFile) {
                    $data[] = [
                        'id' => $image->storageFile->id,
                        'title' => $image->storageFile->title,
                        'description' => $image->storageFile->description,
                        'thumbs' => $image->storageFile->thumbs,
                        'url' => $image->storageFile->url . DS . $image->storageFile->filename,
                        'sort_order' => $image->sort_order
                    ];
                }
            });
        }

        return $data;
    }

    public function getSitePreviewAttribute(): array
    {
        $images = SiteStorageImage::whereSiteId($this->id)
            ->where('type', SiteStorageImage::IMAGE)
            ->orderBy('sort_order', 'asc')
            ->remember(config('app.remember_time'))->get();

        return self::getImages($images);
    }

    public function siteHeaderPreview($size = '70x70')
    {
        if (!empty($this->site_header)) {
            return $this->imageUrl($size, 'site_header', $this->site_header);
        }

        return null;
    }

    public function getLogoLetter(): string
    {
        return strtoupper($this->getText($this->title));
    }

    public function getGlobalParentUrl(): string
    {
        $scheme = getSchema();
        $domain = $this->getMainDomain();

        return "{$scheme}{$domain}" . getPort();
    }

    public function getMainDomain($port = false): string
    {
        if ($this->depth <= 1) {
            return $this->domain . ($port == true ? getPort() : null);
        }

        return main_domain($this->domain) . ($port == true ? getPort() : null);
    }

    public function logoUrl($full = false): string
    {
        $url = '';

        if ($full == false) {
            $fullUrl = '/thumbs/70x70';
        } else {
            $fullUrl = '';
        }

        if ($this->logo) {
            $path = rtrim(domain_upload_url($this->getMainDomain(), 'storage/site_logo' . $fullUrl), '/') . '/';
            $url = $path . $this->logo;
        }

        return $url;
    }

    public function faviconUrl(): array
    {
        return self::getSiteMedia($this, SiteStorageImage::FAVICON);
    }

    public function headerUrl($folder = ''): string
    {
        $url = '';

        if ($this->header) {
            $path = rtrim(domain_upload_url($this->getMainDomain(), 'storage/site_header/thumbs/1920x1080'), DS) . DS;

            if ($folder) {
                $url = $path . rtrim($folder, '/') . '/' . $this->header;
            } else {
                $url = $path . $this->header;
            }
        }

        return $url;
    }

    public function headerHomeUrl($folder = ''): string
    {
        $url = '';

        if ($this->header_home) {
            $path = rtrim(domain_upload_url($this->getMainDomain(), 'storage/site_header/thumbs/1920x1080'), DS) . DS;

            if ($folder) {
                $url = $path . rtrim($folder, '/') . '/' . $this->header_home;
            } else {
                $url = $path . $this->header_home;
            }
        }

        return $url;
    }

    public function originalImage(): string
    {
        $url = null;

        if ($this->image) {
            $path = DS . config('netgamer.upload_dir') . DS . 'storage' . DS . 'site_preview' . DS;
            $url = $path . $this->logo;
        }

        return $url;
    }

    public function originalHaderHome(): string
    {
        $url = null;

        if ($this->image) {
            $path = DS . config('netgamer.upload_dir') . DS . 'storage' . DS . 'site_header' . DS;
            $url = $path . $this->logo;
        }

        return $url;
    }

    public function scopeSort($query, $sort, $dir)
    {
        $sort = strtolower($sort);
        $dir = strtolower($dir);

        if (in_array($dir, $this->directions) && in_array($sort, array_keys($this->sortable))) {
            $query->orderBy($this->sortable[$sort], $dir);
        }

        return $query;
    }

    public function scopeThematic($query)
    {
        $query->select('site.*')->join('domain', 'domain.id', '=', 'site.domain_id')
            ->where(['domain.domain_type' => Domain::DOMAIN_TYPE_THEMATIC]);

        return $query;
    }

    public function manager($user, $action): bool
    {
        $can = false;
        $siteUsers = SiteUser::query()->where('user_id', $user->id)->where('site_id', $this->id)->get();

        if (count($siteUsers) > 0) {
            foreach ($siteUsers as $siteUser) {

                if ($siteUser->user_id == $user->id && $siteUser->user->can($action)) {
                    $can = true;
                    break;
                }
            }
        }

        return $can;
    }

    public function siteUsers(): HasMany
    {
        return $this->hasMany(SiteUser::class);
    }

    public function getTemplateScheme(): Site
    {

        if (!$this->template_scheme_id) {
            $scheme = TemplateScheme::query()->where('default_global', 1)->first();

            if (!$scheme) {
                $scheme = TemplateScheme::query()->get()->random();
            }

            $this->update([
                'template_scheme_id' => $scheme->id
            ]);
        }
        return $this;
    }

    public function setTemplate(): Site
    {
        $template = Template::whereDefault(1)->first();

        if ($template) {
            $this->update([
                'template_id' => $template->id
            ]);
        }

        return $this;
    }

    public function getSiteIdAttribute(): int
    {
        return $this->id;
    }

    public function storageImages()
    {
        return $this->hasMany(SiteStorageImage::class)->with(['storageFile'])->withTrashed();
    }

    public function getLanguageAttribute()
    {
        if ($this->siteDomain && $this->siteDomain->language) {
            return $this->siteDomain->language->alias;
        } else {
            return config('app.locale');
        }
    }

    public function services()
    {
        $this->setConnection('mysqlu');
        return BillingSubscriptionService::whereSiteId($this->id)->whereUserId(Auth::user()->id);
    }

    public function subscription(): HasOne
    {
        $this->setConnection('mysqlu');
        return $this->hasOne(BillingSubscription::class);
    }

    public function feedbackRecipients(): HasMany
    {
        $this->setConnection('mysql');
        return $this->hasMany(FeedbackRecipient::class);
    }

    public function setDeletedAtAttribute($value)
    {
        $this->attributes['deleted_at'] = $value;
    }

    public function preForceDelete()
    {
        Deployer::uninstall($this->domain);
    }

    protected function template(): BelongsTo
    {
        return $this->belongsTo(Template::class);
    }
}