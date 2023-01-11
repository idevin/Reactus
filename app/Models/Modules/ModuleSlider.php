<?php

namespace App\Models\Modules;

use App\Contracts\Module;
use App\Models\Article;
use App\Models\Modules\Module as ModuleModel;
use App\Models\Role;
use App\Models\Section;
use App\Models\Site;
use App\Traits\ModuleAnimationSettings;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Watson\Rememberable\Rememberable;

/**
 * App\Models\Modules\ModuleSlider
 *
 * @property int $id
 * @property int $site_id
 * @property int $module_settings_id
 * @property string|null $name
 * @property int $module_id
 * @property int $view
 * @property int|null $miniature
 * @property int|null $navigation
 * @property int $block_type 1 - Горизонтальный, 2 - Вертикальный
 * @property int $show_statistic
 * @property-read mixed $animation_settings
 * @property-read mixed $slider_id
 * @property-read \App\Models\Modules\Module $module
 * @property-read ModuleSettings $moduleSettings
 * @property-read Collection|ModuleSlide[] $moduleSlides
 * @property-read Site $site
 * @method static Builder|ModuleSlider newModelQuery()
 * @method static Builder|ModuleSlider newQuery()
 * @method static Builder|ModuleSlider query()
 * @method static Builder|ModuleSlider whereBlockType($value)
 * @method static Builder|ModuleSlider whereId($value)
 * @method static Builder|ModuleSlider whereMiniature($value)
 * @method static Builder|ModuleSlider whereModuleId($value)
 * @method static Builder|ModuleSlider whereModuleSettingsId($value)
 * @method static Builder|ModuleSlider whereName($value)
 * @method static Builder|ModuleSlider whereNavigation($value)
 * @method static Builder|ModuleSlider whereShowStatistic($value)
 * @method static Builder|ModuleSlider whereSiteId($value)
 * @method static Builder|ModuleSlider whereView($value)
 * @mixin Eloquent
 * @property-read int|null $module_slides_count
 */
class ModuleSlider extends ModuleBase implements Module
{
    use Rememberable;
    use ModuleAnimationSettings;

    const TYPE_VERTICAL = 2;
    const TYPE_HORIZONTAL = 1;
    const STATIC_TYPE = 1;
    const DYNAMIC_TYPE = 2;
    public static $blockTypes = [
        [
            'id' => self::TYPE_HORIZONTAL,
            'name' => 'Горизонтальный блок'
        ],
        [
            'id' => self::TYPE_VERTICAL,
            'name' => 'Вертикальный блок'
        ]
    ];
    public static $blockViews = [
        [
            'id' => 1,
            'name' => 'Слайдер на всю ширину'
        ],
        [
            'id' => 2,
            'name' => 'Ограниченый по бокам'
        ]
    ];
    public static array $sliderTypes = [
        [
            'id' => self::STATIC_TYPE,
            'name' => 'Статический'
        ],
        [
            'id' => self::DYNAMIC_TYPE,
            'name' => 'Динамический'
        ]
    ];
    public string $permissionName = 'filemanager_access';
    public string $rememberCacheTag = self::class;
    public $timestamps = false;
    protected $table = 'module_slider';
    protected $appends = [
        'slider_id',
        'animation_settings',
    ];
    protected $fillable = [
        'site_id', 'module_settings_id', 'name', 'module_id', 'view',
        'miniature', 'navigation', 'block_type', 'show_statistic'
    ];

    public static function getBlock(...$args)
    {
        $module = $args[0];
        $moduleSlides = $module->moduleSlides;

        if (count($moduleSlides) > 0) {

            $moduleSlides = $moduleSlides->values();

            foreach ($moduleSlides as $index => $slide) {

                $slide = $slide->makeHidden(['module_slider_id']);

                self::checkPublished($moduleSlides, $index, $slide);

                switch ($slide->slider_type) {
                    case self::STATIC_TYPE:
                        self::getStaticSlide($moduleSlides, $index, $slide);
                        break;

                    case self::DYNAMIC_TYPE:
                        self::getFilter($moduleSlides, $slide, $index);
                        break;
                }
            }
            $module->slides = $moduleSlides->values();
        }

        return $module->makeHidden('moduleSlides');
    }

    public static function checkPublished(&$moduleSlides, $index, $slide)
    {
        if (strtotime($slide->publish_start) > time() ||
            ($slide->publish_end && strtotime($slide->publish_end) < time())
        ) {
            $moduleSlides->forget($index);
        }

        foreach ($moduleSlides as $index => $moduleSlide) {
            if (!empty($moduleSlide->section_id) && !$moduleSlide->section) {
                $moduleSlides->forget($index);
            }

            if (!empty($moduleSlide->article_id) && !$moduleSlide->article) {
                $moduleSlides->forget($index);
            }
        }

        return $moduleSlides;
    }

    public static function getStaticSlide($moduleSlides, $index, $slide)
    {
        $slide->makeHidden(['article', 'site', 'section']);

        if (!empty($slide->section_id) && $slide->section) {
            if ($slide->section->user) {
                $slide->author = $slide->section->user
                    ->only(['id', 'thumbs', 'first_name', 'last_name', 'description', 'username']);
            }
        } elseif (!empty($slide->article_id) && $slide->article) {
            if ($slide->article->author) {
                $slide->author = $slide->article->author
                    ->only(['id', 'thumbs', 'first_name', 'last_name', 'description', 'username']);
            }
        } else {
            unset($moduleSlides[$index]);
        }

        return $slide;
    }

    public static function getFilter($moduleSlides, $slide, $index)
    {
        $site = get_site();

        if ($slide->section_id) {
            $section = Section::query()->find($slide->section_id);
            $sections = collect([$section]);

        } else {
            $section = Section::query()->bySite($site->id)->whereNull('parent_id')->first();
            $sections = Section::query()->bySite($site->id)->get();
        }

        $actionLevel = null;

        if ($slide->action_evel) {
            $actionLevel = array_unique($slide->action_level);
        }

        $sortOrder = 'ASC';

        if ($actionLevel && $slide->content_type == ModuleSlide::CONTENT_TYPE_SECTION && $section) {

            if (in_array(ModuleSlide::ACTION_LEVEL_CHILDREN, $actionLevel)) {

                $siblings = self::getPeriod($slide, $section->children);

                if (count($siblings) > 0) {
                    $sections = $sections->merge($siblings);
                }
            }

            if (in_array(ModuleSlide::ACTION_LEVEL_BROTHERS, $actionLevel)) {

                $siblings = self::getPeriod($slide, $section->getSiblings());

                $sections = $sections->merge($siblings);
            }
        }

        if (!empty($slide->content_type)) {

            if ($slide->content_type == ModuleSlide::CONTENT_TYPE_ARTICLE) {

                if ($actionLevel && in_array(ModuleSlide::ACTION_LEVEL_CHILDREN, $actionLevel) && $section) {
                    $siblings = $section->children;
                    $sections = $sections->merge($siblings);
                }

                if ($actionLevel && in_array(ModuleSlide::ACTION_LEVEL_BROTHERS, $actionLevel) && $section) {
                    $siblings = $section->getSiblings();
                    $sections = $sections->merge($siblings);
                }

                $sectionIds = $sections->map(function ($item) use ($section) {
                    return ($item && $item->id != $section->id) ? $item->id : null;
                })->toArray();

                if ($actionLevel && in_array(ModuleSlide::ACTION_LEVEL_SELF, $actionLevel)) {
                    if ($section) {
                        $sectionIds[] = $section->id;
                    }
                }

                $sectionIds = array_filter($sectionIds);

                $articles = Article::query()->whereDraft(0)
                    ->where('active', 1)
                    ->where('status', Article::STATUS_PUBLISHED)
                    ->where('published_at', '<=', Carbon::now()->format('Y-m-d H:i:s'))
                    ->where('site_id', $site->id)
                    ->whereIn('section_id', array_values($sectionIds))
                    ->with(['author', 'section', 'lastComment']);

                switch ($slide->period) {
                    case ModuleSlide::PERIOD_DAY:

                        $articles = $articles
                            ->where('created_at', '>', Carbon::now()->format('Y-m-d 00:00:00'))
                            ->where('created_at', '<', Carbon::now()->format('Y-m-d 23:59:59'));

                        break;

                    case ModuleSlide::PERIOD_MONTH:

                        $articles = $articles
                            ->where('created_at', '>=', Carbon::now()->format('Y-m-01 00:00:00'))
                            ->where('created_at', '<', Carbon::now()->addMonth()->format('Y-m-31 59:59:59'));

                        break;

                    case ModuleSlide::PERIOD_WEEK:

                        $articles = $articles
                            ->where('created_at', '>', Carbon::now()->startOfWeek()->format('Y-m-d 00:00:00'))
                            ->where('created_at', '<', Carbon::now()->endOfWeek()->format('Y-m-d 23:59:59'));

                        break;
                }

                if (!empty($slide->sort_order)) {
                    switch ($slide->sort_order) {
                        case ModuleSlide::SORT_ORDER_ASC:
                            $sortOrder = 'ASC';
                            break;
                        case ModuleSlide::SORT_ORDER_DESC:
                            $sortOrder = 'DESC';
                            break;
                    }
                }

                if (!empty($slide->sort_by)) {
                    switch ($slide->sort_by) {
                        case ModuleSlide::SORT_BY_COMMENTS:
                            $articles = $articles->orderBy('comments_cnt', $sortOrder);
                            break;

                        case ModuleSlide::SORT_BY_DATE:
                            $articles = $articles->orderBy('created_at', $sortOrder);
                            break;

                        case ModuleSlide::SORT_BY_VIEWS:
                            $articles = $articles->orderBy('views_cnt', $sortOrder);
                            break;

                        case ModuleSlide::SORT_BY_RATING:
                            $articles = $articles->orderBy('rating', $sortOrder);
                            break;
                    }
                }
                if (isset($moduleSlides[$index])) {
                    $moduleSlides[$index]->data = $articles->limit($slide->slides_count)->get()->map(function ($section) {
                        return $section->only(['id', 'title', 'content_short', 'title', 'thumbs', 'url']);
                    });
                }
            }

            if ($slide->content_type == ModuleSlide::CONTENT_TYPE_SECTION && $section) {
                $method = 'sortBy';

                if (!empty($slide->sort_by)) {

                    if (!empty($slide->sort_order)) {
                        if ($slide->sort_order == ModuleSlide::SORT_ORDER_DESC) {
                            $method = 'sortByDesc';
                        }
                    }

                    switch ($slide->sort_by) {
                        case ModuleSlide::SORT_BY_COMMENTS:
                            $sections = $sections->$method('comments_cnt');
                            break;

                        case ModuleSlide::SORT_BY_DATE:
                            $sections = $sections->$method('created_at');
                            break;

                        case ModuleSlide::SORT_BY_VIEWS:
                            $sections = $sections->$method('views_cnt');
                            break;

                        case ModuleSlide::SORT_BY_RATING:
                            $sections = $sections->$method('rating');
                            break;
                    }
                }
                if (isset($moduleSlides[$index])) {
                    $moduleSlides[$index]->data = $sections->map(function ($section) {
                        return $section->only(['id', 'title', 'content_short', 'image', 'title', 'thumbs', 'url']);
                    })->take($slide->slides_count)->values();
                }
            }
        }

        return $moduleSlides->values();
    }

    public static function getPeriod($slide, $siblings)
    {
        $now = Carbon::now();

        return match ($slide->period) {
            ModuleSlide::PERIOD_DAY => $siblings->filter(function ($item) use ($now) {
                return self::getResult($item, $now->format('Y-m-d 00:00:00'), $now->format('Y-m-d 23:59:59'));
            }),
            ModuleSlide::PERIOD_MONTH => $siblings->filter(function ($item) use ($now) {
                return self::getResult($item, $now->format('Y-m-01 00:00:00'), $now->format('Y-m-31 23:59:59'));
            }),
            ModuleSlide::PERIOD_WEEK => $siblings->filter(function ($item) use ($now) {
                return self::getResult($item, $now->startOfWeek()->format('Y-m-d 00:00:00'),
                    $now->endOfWeek()->format('Y-m-d 23:59:59'));
            }),
        };
    }

    public static function getResult($item, $start, $end): bool
    {
        if ((strtotime($item['created_at']->format('Y-m-d H:i:s')) > strtotime($start) &&
                strtotime($item['created_at']->format('Y-m-d H:i:s')) < strtotime($end)) || (
                strtotime($item['updated_at']->format('Y-m-d H:i:s')) > strtotime($start) &&
                strtotime($item['updated_at']->format('Y-m-d H:i:s')) < strtotime($end))) {
            return true;
        }
        return false;
    }

    static function options(...$args): array
    {

        $articles = Article::published()
            ->take(5)
            ->where('site_id', $args[0]->id)
            ->orderBy('created_at', 'desc')->get(['id', 'title', 'content_short', 'content', 'image'])
            ->makeHidden(['attached', 'origin', 'last_comment', 'last_comment_url',
                'tags', 'images', 'site', 'tagged', 'voted', 'updated_at_formated',
                'created_at_formated', 'content', 'announce', 'announce_object', 'author'])
            ->map(self::filterContent());

        $sections = Section::whereSiteId($args[0]->id)
            ->take(10)->orderBy('created_at', 'desc')
            ->get(['id', 'title', 'content_short', 'content', 'image'])
            ->makeHidden(['attached', 'origin', 'last_article_id', 'last_article',
                'tags', 'subsections_cnt', 'children', 'parent_id', 'images', 'updated_at_formated',
                'created_at_formated', 'content', 'user', 'announce', 'announce_object', 'path'])
            ->map(self::filterContent());

        $roles = Role::query()->orderBy('description')->get();

        return [
            'static_search_objects' => [
                'sections' => $sections,
                'articles' => $articles
            ],
            'dynamic_search_objects' => [
                'sections' => $sections
            ],
            'navigation' => ModuleSlide::$blockNavigation,
            'block_type' => self::$blockTypes,
            'view' => self::$blockViews,
            'miniature' => ModuleSlide::$blockPreview,
            'slider_type' => self::$sliderTypes,
            'period' => ModuleSlide::$periods,
            'sort_order' => ModuleSlide::$sortOrder,
            'publish' => ModuleSlide::$publish,
            'sort_by' => ModuleSlide::$sortBy,
            'slides_count' => ModuleSlide::$slidesCount,
            'content_type' => ModuleSlide::$contentTypes,
            'roles' => $roles
        ];
    }

    public static function filterContent(): \Closure
    {
        return function ($object) {
            if (empty($object->content_short)) {
                $object->content_short = truncate_content($object->content, 160, true, true);
            }
            return $object;
        };
    }

    static function id(...$args)
    {
        // TODO: Implement id() method.
    }

    public function moduleSlides(): HasMany
    {
        return $this->hasMany(ModuleSlide::class, 'module_slider_id', 'id');
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function moduleSettings(): BelongsTo
    {
        return $this->belongsTo(ModuleSettings::class);
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(ModuleModel::class);
    }

    public function getSliderIdAttribute(): int
    {
        return $this->id;
    }
}