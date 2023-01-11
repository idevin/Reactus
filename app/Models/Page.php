<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Watson\Rememberable\Rememberable;

/**
 * App\Models\Page
 *
 * @property int $id
 * @property int $site_id
 * @property int|null $user_id
 * @property string $title
 * @property string $slug
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $is_edit_mode
 * @property int $is_active
 * @property string|null $seo_title
 * @property string|null $seo_description
 * @property string|null $seo_keywords
 * @property int $is_home
 * @property-read Collection|\App\Models\PageStroke[] $content
 * @property-read int|null $content_count
 * @property-read Collection|\App\Models\PageStroke[] $footer
 * @property-read int|null $footer_count
 * @property-read mixed $url
 * @property-read Collection|\App\Models\PageStroke[] $header
 * @property-read int|null $header_count
 * @property-read Collection|\App\Models\PageStrokeRevision[] $revisionStrokes
 * @property-read int|null $revision_strokes_count
 * @property-read Collection|\App\Models\PageStroke[] $strokes
 * @property-read int|null $strokes_count
 * @method static Builder|Page active()
 * @method static Builder|Page bySite($siteId)
 * @method static Builder|Page home()
 * @method static Builder|Page newModelQuery()
 * @method static Builder|Page newQuery()
 * @method static Builder|Page query()
 * @method static Builder|Page whereCreatedAt($value)
 * @method static Builder|Page whereId($value)
 * @method static Builder|Page whereIsActive($value)
 * @method static Builder|Page whereIsEditMode($value)
 * @method static Builder|Page whereIsHome($value)
 * @method static Builder|Page whereSeoDescription($value)
 * @method static Builder|Page whereSeoKeywords($value)
 * @method static Builder|Page whereSeoTitle($value)
 * @method static Builder|Page whereSiteId($value)
 * @method static Builder|Page whereSlug($value)
 * @method static Builder|Page whereTitle($value)
 * @method static Builder|Page whereUpdatedAt($value)
 * @method static Builder|Page whereUserId($value)
 * @mixin \Eloquent
 */
class Page extends Model
{
    use Rememberable;

    const HOME_PAGE_ID = 1;
    public string $rememberCacheTag = self::class;
    public $timestamps = true;
    protected $relations = [
        'header' => PageStroke::class,
        'footer' => PageStroke::class,
        'content' => PageStroke::class
    ];
    protected $appends = ['url'];
    protected $table = 'page';
    protected $fillable = [
        'slug', 'site_id', 'user_id', 'created_at', 'updated_at', 'is_edit_mode', 'is_active',
        'seo_title', 'seo_description', 'seo_keywords', 'id', 'is_home', 'title', 'url'
    ];
    protected $connection = 'mysql';

    public static function createDefault(): self
    {
        $check = [
            'title' => __('Home Page'),
            'site_id' => get_site()->id
        ];

        $data = $check + [
                'user_id' => \Auth::user()->id ?? null,
                'is_edit_mode' => 0,
                'is_active' => 1,
                'is_home' => 1
            ];

        $page = self::query()->firstOrCreate($check, $data);

        $page->refresh();

        return $page;
    }

    protected static function boot()
    {
        parent::boot();
        Page::creating(function ($page) {

            if (empty($page->slug)) {
                $page->slug = slugify($page->name);
            }
        });

        Page::updating(function ($page) {
            if (empty($page->slug)) {
                $page->slug = slugify($page->name);
            }
        });
    }

    public function header()
    {
        return $this->hasMany(PageStroke::class)->wherePosition(PageStroke::POSITION_HEADER)
            ->with('modules')->orderBy('sort_order', 'asc');
    }

    public function footer()
    {
        return $this->hasMany(PageStroke::class)->wherePosition(PageStroke::POSITION_FOOTER)
            ->with('modules')->orderBy('sort_order', 'asc');
    }

    public function content()
    {
        return $this->hasMany(PageStroke::class)->wherePosition(PageStroke::POSITION_CONTENT)
            ->with('modules')->orderBy('sort_order', 'asc');
    }

    public function strokes(): HasMany
    {
        return $this->hasMany(PageStroke::class);
    }

    public function revisionStrokes(): HasMany
    {
        return $this->hasMany(PageStrokeRevision::class);
    }

    public function scopeActive($query)
    {
        return $query->whereIsActive(1);
    }

    public function scopeBySite($query, $siteId)
    {
        return $query->whereSiteId($siteId);
    }

    public function scopeHome($query)
    {
        return $query->whereIsHome(1);
    }

    public function getUrlAttribute()
    {
        if ($this->is_home == 1) {
            return env('DOMAIN');
        } else {
            return route('page.show', ['slug' => $this->slug, 'id' => $this->id], false);
        }
    }
}
