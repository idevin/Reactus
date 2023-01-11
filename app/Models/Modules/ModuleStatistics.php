<?php

namespace App\Models\Modules;

use App\Contracts\Module as ModuleInterface;
use App\Models\Site;
use App\Traits\ModuleAnimationSettings;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\Modules\ModuleStatistics
 *
 * @property-read \App\Models\Modules\ModuleSettings $moduleSettings
 * @property-read \App\Models\Site $site
 * @mixin Eloquent
 * @property-read mixed $animation_settings
 * @method static Builder|\App\Models\Modules\ModuleStatistics newModelQuery()
 * @method static Builder|\App\Models\Modules\ModuleStatistics newQuery()
 * @method static Builder|\App\Models\Modules\ModuleStatistics query()
 */
class ModuleStatistics extends ModuleBase implements ModuleInterface
{
    use ModuleAnimationSettings;

    public $timestamps = false;
    protected $table = 'module_statistics';
    protected $fillable = ['site_id', 'content', 'module_settings_id', 'sort_order'];

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