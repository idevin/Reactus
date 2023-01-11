<?php

namespace App\Models\Modules;

use App\Contracts\Module;
use App\Models\Article;
use App\Models\Modules\Module as ModuleModel;
use App\Models\Section;
use App\Models\Site;
use App\Traits\ModuleAnimationSettings;
use App\Traits\Response;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

/**
 * App\Models\Modules\ModuleArticle
 *
 * @property int $id
 * @property int $module_settings_id
 * @property int $site_id
 * @property int|null $sort_by 1 - по кол-ву просмотров, 2 - по рейтингу, 3 - по кол-ву коментариев, 4 - по дате публикации
 * @property int|null $view 1 - вертикальный блок, 2 - горизонтальный блок
 * @property int|null $sort_order 1 - по возрастанию, 2 - по убыванию
 * @property int $block_type 1 - Недавно добавленые, 2 - Популярные, 3 - Лучшие, 4 - Обсуждаемые
 * @property string $name
 * @property int $module_id
 * @property int|null $section_id
 * @property int $block_view 0 - список, 1 - сетка
 * @property-read mixed $animation_settings
 * @property-read \App\Models\Modules\Module $module
 * @property-read ModuleSettings $moduleSettings
 * @property-read Site $site
 * @method static Builder|ModuleArticle newModelQuery()
 * @method static Builder|ModuleArticle newQuery()
 * @method static Builder|ModuleArticle query()
 * @method static Builder|ModuleArticle whereBlockType($value)
 * @method static Builder|ModuleArticle whereBlockView($value)
 * @method static Builder|ModuleArticle whereId($value)
 * @method static Builder|ModuleArticle whereModuleId($value)
 * @method static Builder|ModuleArticle whereModuleSettingsId($value)
 * @method static Builder|ModuleArticle whereName($value)
 * @method static Builder|ModuleArticle whereSectionId($value)
 * @method static Builder|ModuleArticle whereSiteId($value)
 * @method static Builder|ModuleArticle whereSortBy($value)
 * @method static Builder|ModuleArticle whereSortOrder($value)
 * @method static Builder|ModuleArticle whereView($value)
 * @method static flushCache()
 * @mixin Eloquent
 */
class ModuleArticle extends ModuleBase implements Module
{
    use ModuleAnimationSettings;

    const VIEW_VERTICAL = 1;
    const VIEW_HORIZONTAL = 2;
    public static array $sortBy = [
        [
            'id' => 1,
            'name' => 'По кол-ву просмотров',
            'alias' => 'views_cnt'
        ],
        [
            'id' => 2,
            'name' => 'По рейтингу',
            'alias' => 'rating'
        ],
        [
            'id' => 3,
            'name' => 'По кол-ву коментариев',
            'alias' => 'comments_cnt'
        ],
        [
            'id' => 4,
            'name' => 'По дате публикации',
            'alias' => 'published_at'
        ]
    ];
    public static array $view = [
        [
            'id' => self::VIEW_VERTICAL,
            'name' => 'Вертикальный блок'
        ],
        [
            'id' => self::VIEW_HORIZONTAL,
            'name' => 'Горизонтальный блок'
        ]
    ];
    public static array $blockTypes = [
        [
            'id' => 1,
            'name' => 'Недавно добавленые',
            'alias' => 'recent',
        ],
        [
            'id' => 2,
            'name' => 'Популярные',
            'alias' => 'popular'
        ],
        [
            'id' => 3,
            'name' => 'Лучшие',
            'alias' => 'best'
        ],
        [
            'id' => 4,
            'name' => 'Обсуждаемые',
            'alias' => 'discussed'
        ]
    ];
    public static array $sortOrder = [
        [
            'id' => 1,
            'name' => 'По возрастанию',
            'alias' => 'asc'
        ],
        [
            'id' => 2,
            'name' => 'По убыванию',
            'alias' => 'desc'
        ]
    ];
    public string $rememberCacheTag = self::class;
    public string $permissionName = '';

    public $timestamps = false;
    protected $table = 'module_article';
    protected $fillable = [
        'view', 'sort_by', 'module_settings_id', 'sort_order',
        'site_id', 'block_type', 'module_id', 'name', 'section_id', 'block_view'
    ];

    protected $appends = [
        'animation_settings',
    ];

    public static function getBlock(...$args)
    {
        $module = $args[0];
        $type = collect(self::$blockTypes)
            ->where('id', $module->block_type)->first();

        if ($type) {
            $module->makeHidden(['site']);
            $module->article = self::{'articles' . ucfirst($type['alias'])}($module);
        }

        return $module;
    }

    public static function articlesBest($moduleArticle)
    {
        $sortOrder = collect($moduleArticle::$sortOrder)
            ->where('id', $moduleArticle->sort_order)->first();

        $sortBy = collect($moduleArticle::$sortBy)->where('id', $moduleArticle->sort_by)->first();

        if (empty($moduleArticle->section_id)) {

            return Article::getMore(
                $moduleArticle->site,
                config('netgamer.home.limit.more'),
                $sortBy['alias'],
                $sortOrder['alias'],
                ['section', 'author', 'tagged'],
                $sortBy['alias'],
                $sortOrder['alias']
            );

        } else {
            return self::getArticlesBySection($moduleArticle, $sortOrder, $sortBy);
        }
    }

    public static function getArticlesBySection($moduleArticle, $sortOrder, $sortBy): Collection
    {
        $section = Section::query()->find($moduleArticle->section_id);
        $articles = collect();

        if ($section) {
            $articles = $section->articles()->active()->published()->orderBy($sortBy['alias'], $sortOrder['alias'])
                ->remember(config('app.remember_time'))->get();
        }

        return $articles;
    }

    public static function articlesRecent($moduleArticle)
    {
        $sortOrder = collect(self::$sortOrder)->where('id', $moduleArticle->sort_order)->first();
        $sortBy = collect(self::$sortBy)->where('id', $moduleArticle->sort_by)->first();

        if (empty($moduleArticle->section_id)) {

            return Article::getMore(
                $moduleArticle->site,
                config('netgamer.home.limit.more'),
                $sortBy['alias'],
                $sortOrder['alias'],
                ['section', 'author', 'tagged'],
                $sortBy['alias'],
                $sortOrder['alias'],
                'recent',
                [$moduleArticle->site_id]
            );
        } else {
            return self::getArticlesBySection($moduleArticle, $sortOrder, $sortBy);
        }
    }

    public static function articlesPopular($moduleArticle)
    {
        $sortOrder = collect(self::$sortOrder)->where('id', $moduleArticle->sort_order)->first();
        $sortBy = collect(self::$sortBy)->where('id', $moduleArticle->sort_by)->first();
        if (empty($moduleArticle->section_id)) {

            return Article::getMore(
                $moduleArticle->site,
                config('netgamer.home.limit.more'),
                $sortBy['alias'],
                $sortOrder['alias'],
                ['section', 'author', 'tagged'],
                $sortBy['alias'], $sortOrder['alias'],
                'popular',
                [$moduleArticle->site_id]
            );

        } else {
            return self::getArticlesBySection($moduleArticle, $sortOrder, $sortBy);
        }
    }

    public static function articlesDisscussed($moduleArticle)
    {
        $sortOrder = collect(self::$sortOrder)->where('id', $moduleArticle->sort_order)->first();
        $sortBy = collect(self::$sortBy)->where('id', $moduleArticle->sort_by)->first();
        if (empty($moduleArticle->section_id)) {

            return Article::getMore(
                $moduleArticle->site,
                config('netgamer.home.limit.more'),
                $sortBy['alias'],
                $sortOrder['alias'],
                ['section', 'author', 'tagged'],
                $sortBy['alias'], $sortOrder['alias'],
                'discussed',
                [$moduleArticle->site_id]
            );

        } else {
            return self::getArticlesBySection($moduleArticle, $sortOrder, $sortBy);
        }
    }

    static function options(...$args)
    {
        $currentSection = null;

        if (isset($args[1]['section_id'])) {
            $currentSection = Section::query()->find($args[0]);
        }

        $site = $args[0];

        $sections = Section::bySite($site->id)->orderBy('id', 'desc')
            ->get()->makeHidden(['content', 'site'])->take(10);

        if ($currentSection) {
            $sections = $sections->add($currentSection);
        }

        return [
            'view' => self::$view,
            'sort_order' => self::$sortOrder,
            'sort_by' => self::$sortBy,
            'block_type' => self::$blockTypes,
            'sections' => $sections
        ];
    }

    static function id(...$args)
    {
        $articleId = $args[0];
        if ($articleId) {
            $article = self::query()->find($articleId);
            if (!$article) {
                return Response::response()->error('Не найдены настройки статей');
            }

            $article = $article->makeHidden(['site_id']);

            return $article->toArray();
        }

        return null;
    }

    public function moduleSettings()
    {
        return $this->belongsTo(ModuleSettings::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function module()
    {
        return $this->belongsTo(ModuleModel::class);
    }
}