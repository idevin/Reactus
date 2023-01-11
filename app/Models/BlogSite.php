<?php

namespace App\Models;

use App\Traits\Media;
use Baum\Extensions\Eloquent\Collection;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\BlogSite
 *
 * @property int $id
 * @property string $domain
 * @property string|null $sections_description
 * @property string|null $articles_description
 * @property string $filter_articles_sort
 * @property string $filter_articles_sort_direction
 * @property string $filter_sections
 * @property string $filter_sections_sort
 * @property string $filter_sections_sort_direction
 * @property int $filter_articles_view
 * @property int $filter_sections_view
 * @property int $articles_limit
 * @property int $sections_limit
 * @property int $show_article_rating
 * @property int $show_section_rating
 * @property int $hide_section_tabs
 * @property string $breadcrumbs
 * @property int $breadcrumbs_position
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string $title
 * @property string $content
 * @property-read \Illuminate\Database\Eloquent\Collection|BlogArticle[] $articles
 * @property-read Collection|BlogSection[] $sections
 * @method static Builder|BlogSite newModelQuery()
 * @method static Builder|BlogSite newQuery()
 * @method static Builder|BlogSite query()
 * @method static Builder|BlogSite whereArticlesDescription($value)
 * @method static Builder|BlogSite whereArticlesLimit($value)
 * @method static Builder|BlogSite whereBreadcrumbs($value)
 * @method static Builder|BlogSite whereBreadcrumbsPosition($value)
 * @method static Builder|BlogSite whereContent($value)
 * @method static Builder|BlogSite whereCreatedAt($value)
 * @method static Builder|BlogSite whereDomain($value)
 * @method static Builder|BlogSite whereFilterArticlesSort($value)
 * @method static Builder|BlogSite whereFilterArticlesSortDirection($value)
 * @method static Builder|BlogSite whereFilterArticlesView($value)
 * @method static Builder|BlogSite whereFilterSections($value)
 * @method static Builder|BlogSite whereFilterSectionsSort($value)
 * @method static Builder|BlogSite whereFilterSectionsSortDirection($value)
 * @method static Builder|BlogSite whereFilterSectionsView($value)
 * @method static Builder|BlogSite whereHideSectionTabs($value)
 * @method static Builder|BlogSite whereId($value)
 * @method static Builder|BlogSite whereSectionsDescription($value)
 * @method static Builder|BlogSite whereSectionsLimit($value)
 * @method static Builder|BlogSite whereShowArticleRating($value)
 * @method static Builder|BlogSite whereShowSectionRating($value)
 * @method static Builder|BlogSite whereTitle($value)
 * @method static Builder|BlogSite whereUpdatedAt($value)
 * @mixin Eloquent
 * @property int|null $domain_id
 * @property-read int|null $articles_count
 * @property-read mixed $url
 * @property-read int|null $sections_count
 * @property-read Domain|null $siteDomain
 * @method static Builder|BlogSite whereDomainId($value)
 * @property int $views
 * @method static Builder|BlogSite whereViews($value)
 * @property int|null $domain_volume_id
 * @property int|null $user_id
 * @property string|null $deleted_at
 * @property-read \App\Models\DomainVolume|null $domainVolume
 * @property-read \App\Models\User|null $user
 * @method static Builder|BlogSite whereDeletedAt($value)
 * @method static Builder|BlogSite whereDomainVolumeId($value)
 * @method static Builder|BlogSite whereUserId($value)
 * @method static firstOrCreate(array $array)
 * @property-read mixed $image_url
 * @property mixed $images
 * @property-read mixed $thumbs
 */
class BlogSite extends Model
{
    use Media;
    use \App\Traits\Site;
    public $timestamps = false;
    protected $table = 'blog_site';
    protected $appends = ['url'];

    protected $fillable = [
        'domain', 'domain_id', 'title', 'content', 'sections_description', 'articles_description',
        'filter_articles_sort', 'filter_articles_sort_direction', 'filter_sections', 'filter_sections_sort',
        'filter_sections_sort_direction', 'filter_articles_view', 'filter_sections_view', 'articles_limit',
        'sections_limit', 'show_article_rating', 'show_section_rating', 'hide_section_tabs', 'breadcrumbs',
        'breadcrumbs_position', 'views', 'domain_volume_id', 'user_id'
    ];

    public function sections(): HasMany
    {
        return $this->hasMany(BlogSection::class, 'site_id');
    }

    public function articles(): HasMany
    {
        return $this->hasMany(BlogArticle::class, 'site_id');
    }

    public function siteDomain(): BelongsTo
    {
        return $this->belongsTo(Domain::class, 'domain_id');
    }

    public function getUrlAttribute(): string
    {
        return route_to_site($this);
    }


    public function originalLogo(): array
    {
        $site = get_site();

        if ($site) {
            return self::getSiteMedia($site);
        }

        return [];
    }

    public function domainVolume(): BelongsTo
    {
        return $this->belongsTo(DomainVolume::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}