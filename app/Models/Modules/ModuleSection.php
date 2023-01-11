<?php

namespace App\Models\Modules;

use App\Contracts\Module;
use App\Models\Modules\Module as ModuleModel;
use App\Models\Section;
use App\Models\Site;
use App\Traits\ModuleAnimationSettings;
use App\Traits\Response;
use App\Traits\Utils;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\Modules\ModuleSection
 *
 * @property int $id
 * @property string|null $name
 * @property int $module_settings_id
 * @property int $site_id
 * @property int $sort_order
 * @property int $sort_by
 * @property int $view
 * @property int $module_id
 * @property int $block_view 0 - список, 1 - сетка
 * @property-read mixed $animation_settings
 * @property-read \App\Models\Modules\Module $module
 * @property-read \App\Models\Modules\ModuleSettings $moduleSettings
 * @property-read Site $site
 * @method static Builder|\App\Models\Modules\ModuleSection newModelQuery()
 * @method static Builder|\App\Models\Modules\ModuleSection newQuery()
 * @method static Builder|\App\Models\Modules\ModuleSection query()
 * @method static Builder|\App\Models\Modules\ModuleSection whereBlockView($value)
 * @method static Builder|\App\Models\Modules\ModuleSection whereId($value)
 * @method static Builder|\App\Models\Modules\ModuleSection whereModuleId($value)
 * @method static Builder|\App\Models\Modules\ModuleSection whereModuleSettingsId($value)
 * @method static Builder|\App\Models\Modules\ModuleSection whereName($value)
 * @method static Builder|\App\Models\Modules\ModuleSection whereSiteId($value)
 * @method static Builder|\App\Models\Modules\ModuleSection whereSortBy($value)
 * @method static Builder|\App\Models\Modules\ModuleSection whereSortOrder($value)
 * @method static Builder|\App\Models\Modules\ModuleSection whereView($value)
 * @mixin Eloquent
 */
class ModuleSection extends ModuleBase implements Module
{
    use ModuleAnimationSettings;

    const SORT_ORDER_ASC = 1;
    const SORT_ORDER_DESC = 2;
    const SORT_BY_TITLE = 1;
    const SORT_BY_RATING = 2;
    const SORT_BY_ARTICLES_COUNT = 3;
    const SORT_BY_CREATED = 4;
    public static $sortOrder = [
        [
            'id' => self::SORT_ORDER_ASC,
            'alias' => 'ASC',
            'name' => 'По возрастанию'
        ],
        [
            'id' => self::SORT_ORDER_DESC,
            'alias' => 'DESC',
            'name' => 'По убыванию'
        ]
    ];
    public static $view = [
        [
            'id' => 1,
            'name' => 'Вертикальный блок'
        ],
        [
            'id' => 2,
            'name' => 'Горизонтальный блок'
        ]
    ];
    public static $sortBy = [
        [
            'id' => self::SORT_BY_TITLE,
            'name' => 'Заголовок',
            'alias' => 'title'
        ],
        [
            'id' => self::SORT_BY_RATING,
            'name' => 'По рейтингу',
            'alias' => 'rating'
        ],
        [
            'id' => self::SORT_BY_ARTICLES_COUNT,
            'name' => 'По кол-ву статей',
            'alias' => 'articles'
        ],
        [
            'id' => self::SORT_BY_CREATED,
            'name' => 'По дате публикации',
            'alias' => 'created_at'
        ]
    ];
    public $timestamps = false;
    protected $table = 'module_section';
    protected $fillable = [
        'site_id', 'module_settings_id', 'view', 'sort_by', 'sort_order', 'name', 'module_id', 'block_view'
    ];

    protected $appends = [
        'animation_settings',
    ];

    public static function getBlock(...$args)
    {
        $module = $args[0];
        $module->makeHidden(['site']);
        $module->section = self::sections($module);
        return $module;
    }

    public static function sections($moduleSection)
    {
        $sortOrder = collect(self::$sortOrder)->where('id', $moduleSection->sort_order)->first();
        $sortBy = collect(self::$sortBy)->where('id', $moduleSection->sort_by)->first();

        $site = get_site();
        $request = request();
        $section = Section::roots()->bySite($site->id)->get()->first();

        if (!$section) {
            $response = new class {
                use Response;
            };

            return (new $response())->error('Раздел не найден...');
        }

        $defaults = [
            'field' => $sortBy['alias'],
            'order' => $sortOrder['alias'],
            'page' => 1,
            'term' => ''
        ];

        $field = $request->get('field', $defaults['field']);
        $order = $request->get('order', $defaults['order']);
        $term = $request->get('term', $defaults['term']);
        $limit = $site->sections_limit;

        $qb = $section->descendantsWithSort($field, $order)
            ->with(['site'])
            ->depth($section->depth + 1);

        $qb->published();

        if ($term) {
            $qb->where('title', 'like', "%$term%");
        }

        $sections = $qb->paginate($limit);
        $sections = Utils::transformUrl($sections);

        $sections->appends([
            'field' => $field,
            'order' => $order,
            'term' => $term,
            'section_id' => $section->id
        ]);

        $sections = $sections->toArray();

        if (!empty($sections['data'])) {

            $sections['data'] = array_map(function ($item) {

                $item = array_intersect_key($item, array_flip([
                    'id', 'thumbs', 'rating', 'tags', 'site', 'articles_cnt',
                    'children', 'title', 'url', 'comments_cnt', 'views_cnt', 'subsections_cnt'
                ]));

                if (!empty($item['children'])) {
                    $item['children'] = array_map(function ($child) {
                        $child = array_intersect_key($child, array_flip(['rating', 'url', 'title']));
                        return $child;

                    }, $item['children']);
                }

                return $item;

            }, $sections['data']);
        }

        $data['sections'] = $sections;
        $data['sectionsFilter'] = $defaults;
        $data['sectionsSortOptions'] = Section::$sortOptions;

        return $data;
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function moduleSettings()
    {
        return $this->belongsTo(ModuleSettings::class);
    }

    public function module()
    {
        return $this->belongsTo(ModuleModel::class);
    }

    static function options(...$args)
    {
        return [
            'view' => self::$view,
            'sort_order' => self::$sortOrder,
            'sort_by' => self::$sortBy
        ];
    }

    static function id(...$args)
    {
        $id = $args[0];
        $section = null;

        if ($id) {
            $section = ModuleSection::query()->find($id);
            if ($section) {
                $section = $section->makeHidden(['site_id'])->toArray();
            }
        }

        return $section;
    }
}