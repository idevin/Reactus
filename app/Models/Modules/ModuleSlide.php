<?php

namespace App\Models\Modules;

use App\Contracts\Module as ModuleInterface;
use App\Models\Article;
use App\Models\Section;
use App\Models\Site;
use App\Models\StorageFile;
use App\Traits\Media;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use JetBrains\PhpStorm\ArrayShape;
use Watson\Rememberable\Rememberable;

/**
 * App\Models\Modules\ModuleSlide
 *
 * @property int $id
 * @property int $module_slider_id
 * @property array|null $roles
 * @property int $sort_order 1 - ASC, 2 - DESC
 * @property string|null $url
 * @property string|null $title
 * @property string|null $name
 * @property string|null $short_description
 * @property int $slider_type 1 - Статический, 2 - динамический
 * @property int|null $content_type 1 - Статья, 2 - раздел
 * @property int|null $sort_by 1 - дата публикации, 2 - рейтинг, 3 - количество просмотров 4 -
 * @property int|null $slides_count
 * @property int|null $period
 * @property string|null $period_start
 * @property string|null $period_end
 * @property int|null $publish
 * @property string|null $publish_start
 * @property string|null $publish_end
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property array|null $action_level
 * @property int|null $section_id
 * @property int|null $article_id
 * @property int|null $image_id
 * @property-read \App\Models\Modules\Article|null $article
 * @property-read mixed $thumbs
 * @property-read ModuleSettings $moduleSettings
 * @property-read Collection|ModuleSlideOptions[] $moduleSlideOptions
 * @property-read ModuleSlider $moduleSlider
 * @property-read \App\Models\Modules\Section|null $section
 * @property-read Site $site
 * @method static Builder|ModuleSlide newModelQuery()
 * @method static Builder|ModuleSlide newQuery()
 * @method static Builder|ModuleSlide query()
 * @method static Builder|ModuleSlide whereActionLevel($value)
 * @method static Builder|ModuleSlide whereArticleId($value)
 * @method static Builder|ModuleSlide whereContentType($value)
 * @method static Builder|ModuleSlide whereCreatedAt($value)
 * @method static Builder|ModuleSlide whereId($value)
 * @method static Builder|ModuleSlide whereImageId($value)
 * @method static Builder|ModuleSlide whereModuleSliderId($value)
 * @method static Builder|ModuleSlide whereName($value)
 * @method static Builder|ModuleSlide wherePeriod($value)
 * @method static Builder|ModuleSlide wherePeriodEnd($value)
 * @method static Builder|ModuleSlide wherePeriodStart($value)
 * @method static Builder|ModuleSlide wherePublish($value)
 * @method static Builder|ModuleSlide wherePublishEnd($value)
 * @method static Builder|ModuleSlide wherePublishStart($value)
 * @method static Builder|ModuleSlide whereRoles($value)
 * @method static Builder|ModuleSlide whereSectionId($value)
 * @method static Builder|ModuleSlide whereShortDescription($value)
 * @method static Builder|ModuleSlide whereSliderType($value)
 * @method static Builder|ModuleSlide whereSlidesCount($value)
 * @method static Builder|ModuleSlide whereSortBy($value)
 * @method static Builder|ModuleSlide whereSortOrder($value)
 * @method static Builder|ModuleSlide whereTitle($value)
 * @method static Builder|ModuleSlide whereUpdatedAt($value)
 * @method static Builder|ModuleSlide whereUrl($value)
 * @mixin Eloquent
 * @property-read int|null $module_slide_options_count
 * @property int $hide_title
 * @property int $hide
 * @method static Builder|ModuleSlide whereHide($value)
 * @method static Builder|ModuleSlide whereHideTitle($value)
 * @method static flushCache()
 * @property-read mixed $image_url
 * @property mixed $images
 */
class ModuleSlide extends ModuleBase implements ModuleInterface
{
    use Media;
    use Rememberable;

    const ACTION_LEVEL_SELF = 1;
    const ACTION_LEVEL_CHILDREN = 2;
    const ACTION_LEVEL_BROTHERS = 3;
    const PERIOD_CUSTOM = 4;
    const PUBLISH_CUSTOM = 4;
    const PERIOD_DAY = 1;
    const PERIOD_WEEK = 2;
    const PERIOD_MONTH = 3;
    const PERIOD_UNLIMITED = 5;
    const SORT_ORDER_ASC = 1;
    const SORT_ORDER_DESC = 2;
    const SORT_BY_DATE = 1;
    const SORT_BY_RATING = 2;
    const SORT_BY_VIEWS = 3;
    const SORT_BY_COMMENTS = 4;
    const CONTENT_TYPE_ARTICLE = 1;
    const CONTENT_TYPE_SECTION = 2;

    public static array $actionLevels = [
        [
            'id' => self::ACTION_LEVEL_SELF,
            'name' => 'Сам'
        ],
        [
            'id' => self::ACTION_LEVEL_CHILDREN,
            'name' => 'Дети'
        ],
        [
            'id' => self::ACTION_LEVEL_BROTHERS,
            'name' => 'Братья'
        ],
    ];

    public static array $blockPreview = [
        [
            'id' => 1,
            'name' => 'На всю ширину'
        ],
        [
            'id' => 2,
            'name' => '3 миниатюры (с отступом)'
        ],
        [
            'id' => 3,
            'name' => '3 миниатюры (без отступа)'
        ]
    ];

    public static array $blockNavigation = [
        [
            'id' => 1,
            'name' => 'Точки'
        ],
        [
            'id' => 2,
            'name' => 'Анонсы'
        ],
        [
            'id' => 3,
            'name' => 'Блоки'
        ]
    ];

    public static array $periods = [
        [
            'id' => self::PERIOD_DAY,
            'name' => 'За день',
            'default' => 0
        ],
        [
            'id' => self::PERIOD_WEEK,
            'name' => 'За неделю',
            'default' => 0
        ],
        [
            'id' => self::PERIOD_MONTH,
            'name' => 'За месяц',
            'default' => 0
        ],
        [
            'id' => self::PERIOD_UNLIMITED,
            'name' => 'Неограничено',
            'default' => 1
        ],
        [
            'id' => self::PERIOD_CUSTOM,
            'name' => 'Свой вариант выборки',
            'default' => 0
        ]
    ];

    public static array $sortOrder = [
        [
            'id' => self::SORT_ORDER_ASC,
            'name' => 'По возрастанию'
        ],
        [
            'id' => self::SORT_ORDER_DESC,
            'name' => 'По убыванию'
        ]
    ];

    public static array $publish = [
        [
            'id' => 1,
            'name' => 'День',
            'default' => 0
        ],
        [
            'id' => 2,
            'name' => 'Неделя',
            'default' => 0
        ],
        [
            'id' => 3,
            'name' => 'Месяц',
            'default' => 0
        ],
        [
            'id' => 5,
            'name' => 'Неограничено',
            'default' => 1
        ],
        [
            'id' => self::PUBLISH_CUSTOM,
            'name' => 'Свой вариант выбора дат',
            'default' => 0
        ]
    ];

    public static array $sortBy = [
        [
            'id' => self::SORT_BY_DATE,
            'name' => 'Дата публикации'
        ],
        [
            'id' => self::SORT_BY_RATING,
            'name' => 'Рейтинг'
        ],
        [
            'id' => self::SORT_BY_VIEWS,
            'name' => 'Количество просмотров'
        ],
        [
            'id' => self::SORT_BY_COMMENTS,
            'name' => 'Количество коментариев'
        ]
    ];

    public static array $slidesCount = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

    public static array $contentTypes = [
        [
            'id' => self::CONTENT_TYPE_ARTICLE,
            'name' => 'Статья'
        ],
        [
            'id' => self::CONTENT_TYPE_SECTION,
            'name' => 'Раздел'
        ]
    ];

    public string $rememberCacheTag = self::class;

    public $timestamps = false;

    protected $hidden = ['article', 'section'];

    protected $table = 'module_slide';

    protected $fillable = [
        'site_id', 'roles', 'sort_order', 'url', 'name', 'title', 'short_description',
        'slider_type', 'content_type', 'sort_by', 'slides_count', 'sort_order', 'period', 'period_start',
        'period_end', 'slides_count', 'publish', 'publish_start', 'publish_end', 'image_id', 'module_slider_id',
        'action_level', 'article_id', 'section_id', 'content_options'
    ];

    protected $appends = [
        'thumbs'
    ];

    protected $casts = [
        'roles' => 'array',
        'action_level' => 'array',
        'content_options' => 'array'
    ];

    public static function getBlock(...$args)
    {
        // TODO: Implement getBlock() method.
    }

    #[ArrayShape(['slider_type' => "array[]", 'period' => "array|array[]", 'sort_order' => "array|array[]",
        'publish' => "int|null", 'sort_by' => "array|array[]", 'slides_count' => "array|int[]",
        'content_type' => "array|array[]"])]
    static function options(...$args): array
    {
        return [
            'slider_type' => ModuleSlider::$sliderTypes,
            'period' => self::$periods,
            'sort_order' => self::$sortOrder,
            'publish' => self::$publish,
            'sort_by' => self::$sortBy,
            'slides_count' => self::$slidesCount,
            'content_type' => self::$contentTypes
        ];
    }

    static function id(...$args)
    {
        // TODO: Implement id() method.
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function moduleSettings(): BelongsTo
    {
        return $this->belongsTo(ModuleSettings::class);
    }

    public function moduleSlider(): BelongsTo
    {
        return $this->belongsTo(ModuleSlider::class);
    }

    public function moduleSlideOptions(): HasMany
    {
        return $this->hasMany(ModuleSlideOptions::class);
    }

    public function getThumbsAttribute()
    {
        $thumbs = [];

        if ($this->slider_type == ModuleSlider::STATIC_TYPE) {
            if (!empty($this->article_id) && $this->article) {
                $thumbs = $this->article->thumbs;
            }
            if (!empty($this->section_id) && $this->section) {
                $thumbs = $this->section->thumbs;
            }
            if (!empty($this->image_id)) {
                $storageFile = StorageFile::withTrashed()->find($this->image_id);
                if ($storageFile) {
                    $thumbs = $storageFile->thumbs;
                }
            }
        }

        return $thumbs;
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function getUrlAttribute()
    {
        $url = $this->attributes['url'];

        if (!empty($this->article_id)) {
            $url = route_to_article($this->article, true);
        }
        if (!empty($this->section_id)) {
            $url = route_to_section($this->section, true);
        }

        return $url;
    }
}