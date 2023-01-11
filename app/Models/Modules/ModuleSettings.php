<?php

namespace App\Models\Modules;

use App\Contracts\Module as ModuleInterface;
use App\Models\Modules\Site as SiteModel;
use App\Traits\DefaultModuleSettings;
use App\Traits\NeoObject;
use App\Traits\Site;
use App\Traits\Utils;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Schema;
use Symfony\Component\HttpFoundation\Request;
use Watson\Rememberable\Rememberable;

/**
 * Class ModuleSettings
 *
 * @package App\Models\Modules
 * @property int $id
 * @property int $position
 * @property int $sort_order
 * @property string $name
 * @property int|null $site_id
 * @property int $module_id
 * @property string|null $object
 * @property int|null $object_id
 * @property int $active
 * @property array|null $settings
 * @property int $default
 * @property-read mixed $module_settings_id
 * @property-read Module $module
 * @property-read \App\Models\Site $site
 * @method static Builder|ModuleSettings byObject($sObjectClass, $iObjectID)
 * @method static Builder|ModuleSettings byPosition($iPosition)
 * @method static Builder|ModuleSettings bySite($siteId)
 * @method static Builder|ModuleSettings createDefaultModules($site)
 * @method static Builder|ModuleSettings getBlocks($object)
 * @method static Builder|ModuleSettings getHomeBlocks($object, Request $request)
 * @method static Builder|ModuleSettings getSettingsBlocks($object)
 * @method static Builder|ModuleSettings newModelQuery()
 * @method static Builder|ModuleSettings newQuery()
 * @method static Builder|ModuleSettings query()
 * @method static Builder|ModuleSettings whereActive($value)
 * @method static Builder|ModuleSettings whereDefault($value)
 * @method static Builder|ModuleSettings whereId($value)
 * @method static Builder|ModuleSettings whereModuleId($value)
 * @method static Builder|ModuleSettings whereName($value)
 * @method static Builder|ModuleSettings whereObject($value)
 * @method static Builder|ModuleSettings whereObjectId($value)
 * @method static Builder|ModuleSettings wherePosition($value)
 * @method static Builder|ModuleSettings whereSettings($value)
 * @method static Builder|ModuleSettings whereSiteId($value)
 * @method static Builder|ModuleSettings whereSortOrder($value)*@method static flushCache()
 * @mixin Eloquent
 */
class ModuleSettings extends ModuleBase implements ModuleInterface
{
    use DefaultModuleSettings;
    use Site;
    use Rememberable;
    use Utils;
    use NeoObject;

    const POSITION_HEADER = 1;
    const POSITION_FOOTER = 2;
    const POSITION_CONTENT = 3;

    public static array $positionOptions = [
        self::POSITION_HEADER => 'header',
        self::POSITION_FOOTER => 'footer',
        self::POSITION_CONTENT => 'content'
    ];

    public static array $positions = [];

    public string $rememberCacheTag = self::class;

    public $timestamps = false;

    protected $table = 'module_settings';

    protected $fillable = [
        'site_id', 'module_id', 'name', 'object', 'object_id', 'position',
        'sort_order', 'active', 'default'
    ];

    protected $appends = [
        'module_settings_id',
    ];

    /**
     * @param string $class
     * @param int $id
     * @param null $position
     * @return array
     */
    public static function getSortDataByObject(string $class, $id, $position = null)
    {
        if (empty($class) || empty($id)) {
            return [];
        }

        $data = [];
        $strokeList = ModuleSettings::byObject($class, $id)->orderBy('sort_order', 'asc');

        if ($position) {
            $strokeList = $strokeList->wherePosition($position);
        }

        $strokeList = $strokeList->get();

        foreach ($strokeList as $item) {
            /** @var ModuleSettings $item */
            $data[] = [
                'id' => $item->id,
                'sort_order' => $item->sort_order,
            ];
        }

        return $data;
    }

    public function site()
    {
        return $this->belongsTo(SiteModel::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    /**
     * @return null
     * @internal param array $moduleOptions
     */
    public function objects()
    {
        $class = $this->module->class;

        $hasSortOrder = Schema::hasColumn(app($class)->getTable(), 'sort_order');
        $hasTable = Schema::hasTable(app($class)->getTable());
        $objects = null;

        if ($hasTable) {

            $objects = app($class)->where([
                'module_settings_id' => $this->id,
                'site_id' => $this->site_id
            ]);

            if ($hasSortOrder == true) {
                $objects = $objects->orderBy('sort_order', 'ASC');
            }

            $objects = $objects->get();
        }

        return $objects;
    }

    public function scopeGetBlocks($query, $object)
    {
        $site = $this->getSite(env('DOMAIN'));

        $blocks = $query->where([
            'object' => get_class($object),
            'object_id' => $object->id,
            'site_id' => $site->id
        ])->orderBy('sort_order', 'ASC')->remember(config('app.remember_time'))->get();

        $positionOptions = $this->blocksArray();

        if (count($blocks) > 0) {
            if (config('netgamer.defaultModuleSettings') == true) {
                $this->getDefaultSettings();
            } else {

                $blocks->each(function ($block) use ($positionOptions) {

                    $block->data = $block->objects();

                    $block->makeHidden(['module', 'object', 'object_id',
                        'default', 'site_id', 'position', 'settings']);

                    self::$positions[$positionOptions[$block->position]][] = $block;
                });
            }
        }

        foreach (self::$positions as $index => &$data) {
            $data = collect($data)->sortBy('sort_order')->values();
        }

        return self::$positions;
    }

    public function blocksArray($positions = array())
    {

        $positionData = function ($positionObject) {
            return collect($positionObject)->map(function ($position) {
                self::$positions[$position] = [];
            });
        };

        if (empty($positions)) {
            $positions = self::$positionOptions;
            $positionData($positions);

            return $positions;
        } else {
            $positions = array_only(self::$positionOptions, $positions);
            $positionData($positions);

            return $positions;
        }
    }

    public function scopeGetHomeBlocks($query, $object, Request $request)
    {
        $site = $this->getSite(env('DOMAIN'));

        $moduleSettings = $query->where([
            'object' => get_class($object),
            'object_id' => $object->id,
            'site_id' => $site->id
        ])->orderBy('sort_order', 'ASC')->get();

        $positionOptions = $this->blocksArray([
            self::POSITION_CONTENT
        ]);

        if (count($moduleSettings) > 0) {
            $this->filterModules($positionOptions, $moduleSettings, $request);
        }

        foreach (self::$positions as $index => &$data) {
            $data = collect($data)->sortBy('sort_order')->values();
        }

        return self::$positions;
    }

    public function filterModules($positionOptions, $moduleSettings, $request)
    {
        $moduleSettings->each(function ($setting) use ($positionOptions, $request) {

            if (isset($positionOptions[$setting->position])) {

                $class = $setting->module->class;

                $hasSortOrder = Schema::hasColumn(app($class)->getTable(), 'sort_order');
                $hasTable = Schema::hasTable(app($class)->getTable());
                $objects = null;

                if ($hasTable) {
                    $objects = app($class)->where([
                        'module_settings_id' => $setting->id,
                        'site_id' => $setting->site_id
                    ]);

                    if ($hasSortOrder == true) {
                        $objects = $objects->orderBy('sort_order', 'ASC');
                    }

                    if ($class == ModuleStroke::class) {
                        $objects = ModuleStroke::getObjects($objects, $request);
                    } else {
                        $objects = $objects->get();
                    }
                }

                $setting->data = $objects;

                $setting->makeHidden(['module', 'object', 'object_id',
                    'default', 'site_id', 'sort_order', 'position', '']);

                self::$positions[$positionOptions[$setting->position]][] = $setting;
            }
        });
    }

    public function scopeGetSettingsBlocks($query, $object)
    {
        $site = $this->getSite(env('DOMAIN'));

        if (!$site) {
            return false;
        }

        $blocks = $query->where([
            'object' => get_class($object),
            'object_id' => $object->id,
            'site_id' => $site->id,
        ])->orderBy('sort_order', 'ASC')->remember(config('app.remember_time'))->get();

        $positionOptions = $this->blocksArray([
            self::POSITION_HEADER,
            self::POSITION_FOOTER
        ]);

        if (count($blocks) > 0) {
            if (config('netgamer.defaultModuleSettings') == true) {
                $this->getDefaultSettings();
            } else {

                $blocks->each(function ($block) use ($positionOptions) {
                    if (isset($positionOptions[$block->position])) {
                        if ($block->active == 1) {

                            $block->data = $block->objects();

                            $block->makeHidden(['module', 'object', 'object_id',
                                'default', 'site_id', 'sort_order', 'position']);

                            self::$positions[$positionOptions[$block->position]][] = $block;
                        }
                    }
                });
            }
        }

        foreach (self::$positions as $index => &$data) {
            $data = collect($data)->sortBy('sort_order')->values();
        }

        return self::$positions;
    }

    public function getModuleSettingsIdAttribute()
    {
        return $this->id;
    }

    public function scopeBySite($query, $siteId)
    {
        return $query->where(['site_id' => $siteId]);
    }

    public function scopeCreateDefaultModules($query, $site)
    {
        $classesHeader = [ModuleMenu::class, ModuleInformation::class, ModuleFeedback::class];
        $classesFooter = [ModuleContacts::class, ModuleSocials::class, ModuleFeedback::class];

        $modulesHeaders = Module::query()->whereIn('class', $classesHeader)->get();
        $moduleFooters = Module::query()->whereIn('class', $classesFooter)->get();

        $createDefaultModules = function ($modules, $position) use ($site) {
            foreach ($modules as $module) {
                $exists = ModuleSettings::whereSiteId($site->id)->where('module_id', $module->id)
                    ->where('position', $position)->get()->first();

                if (!$exists) {
                    ModuleSettings::create([
                        'site_id' => $site->id,
                        'module_id' => $module->id,
                        'object' => SiteModel::class,
                        'position' => $position,
                        'object_id' => $site->id,
                        'name' => $module->name,
                        'active' => 1
                    ]);
                }
            }
        };

        $createDefaultModules($modulesHeaders, ModuleSettings::POSITION_HEADER);
        $createDefaultModules($moduleFooters, ModuleSettings::POSITION_FOOTER);

        return $query;
    }

    /**
     * @param $query
     * @param string $class
     * @param int $id
     *
     * @return $this|self
     */
    public function scopeByObject($query, $class, $id)
    {
        if (empty($class) || empty($id)) {
            return $query;
        }

        return $query->where('object', $class)->where('object_id', $id);
    }

    /**
     * @param $obQuery
     * @param int $iPosition
     *
     * @return $this|self
     */
    public function scopeByPosition($obQuery, $iPosition)
    {
        if (empty($iPosition)) {
            return $obQuery;
        }

        return $obQuery->where('position', $iPosition);
    }

    public function updateSorting()
    {
        if (!isset($this->attributes['sort_order'])) {
            return;
        }
        $iSortOrder = (int)$this->attributes['sort_order'];
        $arProcessedIDList = [];
        while (true) {

            /** @var self $obModuleSettings */
            $obModuleSettings = self::byObject($this->object, $this->object_id)
                ->byPosition($this->position)
                ->where('sort_order', '=', $iSortOrder)->where('id', '<>', $this->id)
                ->whereNotIn('id', array_values($arProcessedIDList))
                ->first();

            if (empty($obModuleSettings)) {
                break;
            }

            $obModuleSettings->sort_order = $obModuleSettings->sort_order + 1;
            $obModuleSettings->save();
            $arProcessedIDList[] = $obModuleSettings->id;
            $iSortOrder++;
        }
    }

    public static function getBlock(...$args)
    {
        // TODO: Implement getBlock() method.
    }

    static function options(...$args)
    {
        // TODO: Implement options() method.
    }

    static function id(...$args)
    {
        // TODO: Implement id() method.
    }
}
