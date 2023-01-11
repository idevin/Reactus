<?php

namespace App\Models\Modules;

use App\Contracts\Module;
use App\Models\Article;
use App\Models\Modules\Module as ModuleModel;
use App\Models\Site;
use App\Traits\Response;
use Auth;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Modules\ModuleComment
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
 * @property-read \App\Models\Modules\Module $moduleSettings
 * @property-read Site $site
 * @method static Builder|ModuleComment newModelQuery()
 * @method static Builder|ModuleComment newQuery()
 * @method static Builder|ModuleComment query()
 * @method static Builder|ModuleComment whereBlockView($value)
 * @method static Builder|ModuleComment whereId($value)
 * @method static Builder|ModuleComment whereModuleId($value)
 * @method static Builder|ModuleComment whereModuleSettingsId($value)
 * @method static Builder|ModuleComment whereName($value)
 * @method static Builder|ModuleComment whereSiteId($value)
 * @method static Builder|ModuleComment whereSortBy($value)
 * @method static Builder|ModuleComment whereSortOrder($value)
 * @method static Builder|ModuleComment whereView($value)
 * @mixin Eloquent
 */
class ModuleComment extends ModuleBase implements Module
{
    use \App\Traits\ModuleAnimationSettings;

    const SORT_ORDER_ASC = 1;
    const SORT_ORDER_DESC = 2;
    const SORT_BY_RATING = 2;
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
            'id' => self::SORT_BY_RATING,
            'name' => 'По рейтингу',
            'alias' => 'rating'
        ],
        [
            'id' => self::SORT_BY_CREATED,
            'name' => 'По дате',
            'alias' => 'created_at'
        ]
    ];
    public $timestamps = false;
    protected $table = 'module_comment';

    /**
     * @DB_DELETE module_id
     */
    protected $fillable = [
        'site_id', 'module_settings_id', 'view', 'sort_by', 'sort_order', 'name', 'block_view'
    ];

    protected $appends = [
        'animation_settings',
    ];

    public static function getBlock(...$args)
    {
        $module = $args[0];
        $module->makeHidden(['site']);
        $module->comment = self::comments($module, request());
        return $module;
    }

    public static function comments($moduleComment, $request)
    {
        $site = get_site();
        $data = [];

        if (!$site) {
            return Response::response()->error('Сайт не найден...');
        }

        $sortOrder = collect(self::$sortOrder)->where('id', $moduleComment->sort_order)->first();
        $sortBy = collect(self::$sortBy)->where('id', $moduleComment->sort_by)->first();

        $defaults = [
            'field' => $sortBy['alias'],
            'order' => $sortOrder['alias'],
            'page' => 1,
            'term' => '',
        ];

        $field = $request->get('field', $defaults['field']);
        $order = $request->get('order', $defaults['order']);
        $term = $request->get('term', $defaults['term']);
        $sectionId = $request->get('section_id', null);
        $limit = config('netgamer.module_comments_limit');

        $qb = Article::query()->where(function ($query) use ($site) {
            $query->where('site_id', $site->id)
                ->where('published_at', '<=', Carbon::now()->format('Y-m-d H:i:s'))
                ->where('status', Article::STATUS_PUBLISHED)
                ->whereNotNull('last_comment_at')
                ->where('active', 1)
                ->where('comments_cnt', '>', 0);
        })->with(['author', 'section', 'lastComment'])
            ->sort($field, $order)->orderBy('comments_cnt', 'DESC');

        if (!Auth::user()) {
            $qb = $qb->active();
        } else {
            $qb = $qb->orWhere(function ($query) use ($site) {
                $query->where('author_id', Auth::user()->id)
                    ->where('site_id', $site->id)
                    ->where('comments_cnt', '>', 0);
            });
        }

        if ($term) {
            $qb->where('title', 'like', "%$term%");
        }

        $qb->where('site_id', $site->id);

        if ($sectionId) {
            $qb->where('section_id', $sectionId);
        }

        $articles = $qb->paginate($limit, ['*'], 'page');

        $articles->appends([
            'field' => $field,
            'order' => $order,
            'term' => $term
        ]);

        $data['articles'] = $articles->toArray();
        $data['articlesFilter'] = $defaults;
        $data['articlesSortOptions'] = ModuleArticle::$sortBy;

        return $data;
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function moduleSettings(): BelongsTo
    {
        return $this->belongsTo(ModuleModel::class);
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(ModuleModel::class);
    }

    static function options(...$args): array
    {
        return [
            'view' => self::$view,
            'sort_order' => self::$sortOrder,
            'sort_by' => self::$sortBy
        ];
    }

    static function id(...$args)
    {
        // TODO: Implement id() method.
    }
}