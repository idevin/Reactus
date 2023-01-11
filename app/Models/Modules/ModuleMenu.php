<?php

namespace App\Models\Modules;

use App\Contracts\Module as ModuleInterface;
use App\Models\Site;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\Modules\ModuleMenu
 *
 * @property int $id
 * @property int $site_id
 * @property string $name
 * @property string $url
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int $module_settings_id
 * @property int $sort_order
 * @property-read mixed $animation_settings
 * @property-read ModuleSettings $moduleSettings
 * @property-read Site $site
 * @method static Builder|ModuleMenu newModelQuery()
 * @method static Builder|ModuleMenu newQuery()
 * @method static Builder|ModuleMenu query()
 * @method static Builder|ModuleMenu whereCreatedAt($value)
 * @method static Builder|ModuleMenu whereId($value)
 * @method static Builder|ModuleMenu whereModuleSettingsId($value)
 * @method static Builder|ModuleMenu whereName($value)
 * @method static Builder|ModuleMenu whereSiteId($value)
 * @method static Builder|ModuleMenu whereSortOrder($value)
 * @method static Builder|ModuleMenu whereUpdatedAt($value)
 * @method static Builder|ModuleMenu whereUrl($value)
 * @mixin Eloquent
 * @property int $submodule
 * @property string|null $settings
 * @property string|null $content_options
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Modules\ModuleMenuUrl[] $urls
 * @property-read int|null $urls_count
 * @method static Builder|ModuleMenu whereContentOptions($value)
 * @method static Builder|ModuleMenu whereSettings($value)
 * @method static Builder|ModuleMenu whereSubmodule($value)
 */
class ModuleMenu extends ModuleBase implements ModuleInterface
{
    use \App\Traits\ModuleAnimationSettings;

    public $timestamps = false;
    public string $permissionName = 'site_menu_horizontal_manage';

    protected $table = 'module_menu';
    protected $fillable = [
        'site_id', 'name', 'url', 'module_settings_id', 'sort_order'
    ];

    protected $with = ['urls'];

    protected $appends = [
        'animation_settings',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function moduleSettings()
    {
        return $this->belongsTo(ModuleSettings::class);
    }

    public function urls() {
        return $this->hasMany(ModuleMenuUrl::class, 'module_menu_id');
    }

    static function options(...$args)
    {
        // TODO: Implement options() method.
    }

    public static function getBlock(...$args)
    {
        return $args[0]->urls;
    }

    static function id(...$args)
    {
        // TODO: Implement id() method.
    }
}