<?php

namespace App\Models\Modules;

use App\Contracts\Module;
use App\Http\Controllers\Api\Catalog\ObjectsController;
use App\Models\Modules\Module as ModuleModel;
use App\Models\NeoCard;
use App\Models\NeoUserCatalog;
use App\Models\Site;
use App\Traits\NeoObject;
use App\Traits\Response;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Modules\ModuleCatalog
 *
 * @property int $id
 * @property int $site_id
 * @property int $module_settings_id
 * @property string|null $sort_order
 * @property string|null $name
 * @property int $module_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property array|null $filter_settings
 * @property string|null $sort_options
 * @property int $object_id
 * @property string|null $sort_by
 * @property int|null $hide_filter
 * @property-read mixed $animation_settings
 * @property-read \App\Models\Modules\Module $moduleSettings
 * @property-read Site $site
 * @method static Builder|ModuleCatalog newModelQuery()
 * @method static Builder|ModuleCatalog newQuery()
 * @method static Builder|ModuleCatalog query()
 * @method static Builder|ModuleCatalog whereCreatedAt($value)
 * @method static Builder|ModuleCatalog whereFilterSettings($value)
 * @method static Builder|ModuleCatalog whereHideFilter($value)
 * @method static Builder|ModuleCatalog whereId($value)
 * @method static Builder|ModuleCatalog whereModuleId($value)
 * @method static Builder|ModuleCatalog whereModuleSettingsId($value)
 * @method static Builder|ModuleCatalog whereName($value)
 * @method static Builder|ModuleCatalog whereObjectId($value)
 * @method static Builder|ModuleCatalog whereSiteId($value)
 * @method static Builder|ModuleCatalog whereSortBy($value)
 * @method static Builder|ModuleCatalog whereSortOptions($value)
 * @method static Builder|ModuleCatalog whereSortOrder($value)
 * @method static Builder|ModuleCatalog whereUpdatedAt($value)
 * @mixin Eloquent
 */
class ModuleCatalog extends ModuleBase implements Module
{
    use \App\Traits\ModuleAnimationSettings;

    const DEFAULT_SORT_BY = 'views';
    const DEFAULT_SORT_ORDER = 'desc';

    public string $permissionName = 'catalog_view';

    public $timestamps = false;

    protected $table = 'module_catalog';
    protected $fillable = [
        'site_id', 'module_settings_id', 'sort_order', 'name',
        'module_id', 'filter_settings', 'object_id', 'sort_by', 'hide_filter'
    ];

    protected $casts = [
        'filter_settings' => 'array'
    ];

    protected $appends = [
        'animation_settings',
    ];

    public static function getBlock(...$args)
    {
        $module = $args[0];
        $module->makeHidden(['site']);

        $neoObject = NeoUserCatalog::query()->find($module->object_id);
        if (!$neoObject) {
            return Response::response()->error('Такого каталога нет');
        }

        $request = request();

        $cards = $neoObject->cards()->visible()->paginate(config('app.catalog_limit'))->items();

        $request->query->add([
            'object_id' => $module->object_id,
            'sort' => $module->sort_by,
            'order' => $module->sort_order
        ]);

        if (!empty($module->filter_settings)) {

            $newSettings = collect($module->filter_settings)->map(function ($setting) {
                if (isset($setting['data']['value']) && !empty($setting['data']['value'])) {
                    return [
                        'id' => $setting['id'],
                        'term' => $setting['data']['value']
                    ];
                }
                return null;
            })->filter()->toArray();

            $request->query->add([
                'fields' => $newSettings,
            ]);

            $module->catalog = app(ObjectsController::class)
                ->search($request);
            $module->catalog = $module->catalog->getData()->data;

        } else {
            $module->catalog = NeoObject::getCatalog($module->object_id);
        }

        $data = NeoUserCatalog::getFilter($module->object_id);

        $module->filter = $data;
        return $module;
    }

    static function options(...$args): array
    {
        $objectsArray = NeoObject::catalogTree($args[0]);
        $data['objects'] = $objectsArray;
        $data['filter'] = [];
        $data['sort_options'] = NeoCard::$filter;
        $data['default_sort_options'] = NeoCard::$defaultFilter;

        return $data;
    }

    static function id(...$args)
    {
        $id = $args[0];
        $site = $args[1];
        $data = [];
        $filter = [];
//        $user = Auth::user();
        if ($id) {
            $defaultArray = ['filter' => [], 'catalog' => []];
            $moduleCatalog = ModuleCatalog::query()->where([
                'id' => $id,
                'site_id' => $site->id
            ])->first();

            if ($moduleCatalog) {
                $data = $moduleCatalog;
            } else {
                return $defaultArray;
            }


            $catalog = NeoUserCatalog::getBySiteUserId(get_site()->id, Auth::user()->id, $id);

            if ($catalog === false) {
                return $defaultArray;
            }

            $catalog = $catalog->cards()->whereHidden(0)->with(['category', 'userFieldGroups' => function ($query) {
                $query->with(['userFields' => function ($query) {
                    $query->with('fieldPrototype');
                }]);
            }])->paginate(10);


            $catalog->update(['catalog_views' => $catalog->catalog_views + 1]);

            $data['filter'] = $filter;
            $data['catalog'] = $catalog;
        }

        return $data;
    }

    public
    function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public
    function moduleSettings(): BelongsTo
    {
        return $this->belongsTo(ModuleModel::class);
    }
}