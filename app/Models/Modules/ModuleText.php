<?php

namespace App\Models\Modules;

use App\Contracts\Module;
use App\Models\Site;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Modules\ModuleText
 *
 * @property int $id
 * @property int $site_id
 * @property int $module_settings_id
 * @property int $sort_order
 * @property string $content
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $name
 * @property int $module_id
 * @property-read mixed $animation_settings
 * @property-read ModuleSettings $moduleSettings
 * @property-read Site $site
 * @method static Builder|ModuleText newModelQuery()
 * @method static Builder|ModuleText newQuery()
 * @method static Builder|ModuleText query()
 * @method static Builder|ModuleText whereContent($value)
 * @method static Builder|ModuleText whereCreatedAt($value)
 * @method static Builder|ModuleText whereId($value)
 * @method static Builder|ModuleText whereModuleId($value)
 * @method static Builder|ModuleText whereModuleSettingsId($value)
 * @method static Builder|ModuleText whereName($value)
 * @method static Builder|ModuleText whereSiteId($value)
 * @method static Builder|ModuleText whereSortOrder($value)
 * @method static Builder|ModuleText whereUpdatedAt($value)
 * @mixin Eloquent
 * @property int $submodule
 * @method static Builder|ModuleText whereSubmodule($value)
 */
class ModuleText extends ModuleBase implements Module
{
    use \App\Traits\ModuleAnimationSettings;

    public $timestamps = false;

    protected $table = 'module_text';

    protected $fillable = [
        'site_id', 'content', 'sort_order', 'name'
    ];

    protected $appends = [
        'animation_settings',
    ];

    public static function getBlock(...$args)
    {
        return $args[0];
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    static function options(...$args)
    {
        // TODO: Implement options() method.
    }

    static function id(...$args)
    {
        return self::query()->whereId($args[0])->whereSiteId($args[1]->id)->first();
    }
}