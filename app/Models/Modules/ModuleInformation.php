<?php

namespace App\Models\Modules;

use App\Contracts\Module as ModuleInterface;
use App\Models\Site;
use App\Traits\ModuleAnimationSettings;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Modules\ModuleInformation
 *
 * @property int $id
 * @property int $site_id
 * @property int $module_settings_id
 * @property string $content
 * @property int $block_type 1 - информация, 2 - статистика
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int $sort_order
 * @property-read mixed $animation_settings
 * @property-read ModuleSettings $moduleSettings
 * @property-read Site $site
 * @method static Builder|ModuleInformation newModelQuery()
 * @method static Builder|ModuleInformation newQuery()
 * @method static Builder|ModuleInformation query()
 * @method static Builder|ModuleInformation whereBlockType($value)
 * @method static Builder|ModuleInformation whereContent($value)
 * @method static Builder|ModuleInformation whereCreatedAt($value)
 * @method static Builder|ModuleInformation whereId($value)
 * @method static Builder|ModuleInformation whereModuleSettingsId($value)
 * @method static Builder|ModuleInformation whereSiteId($value)
 * @method static Builder|ModuleInformation whereSortOrder($value)
 * @method static Builder|ModuleInformation whereUpdatedAt($value)
 * @mixin Eloquent
 * @property string|null $name
 * @property string|null $react_data
 * @method static Builder|ModuleInformation whereName($value)
 * @method static Builder|ModuleInformation whereReactData($value)
 */
class ModuleInformation extends ModuleBase implements ModuleInterface
{
    use ModuleAnimationSettings;

    const BLOCK_TYPE_STATISTICS = 2;
    const BLOCK_TYPE_INFORMATION = 1;

    public static $blockTypes = [
        self::BLOCK_TYPE_INFORMATION => 'Информация',
        self::BLOCK_TYPE_STATISTICS => 'Статистика'
    ];

    public $timestamps = false;
    protected $table = 'module_information';
    protected $fillable = [
        'site_id', 'content', 'module_settings_id', 'sort_order', 'block_type', 'name', 'react_data'
    ];

    protected $appends = [
        'animation_settings',
    ];

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function moduleSettings(): BelongsTo
    {
        return $this->belongsTo(ModuleSettings::class);
    }

    static function options(...$args)
    {
        // TODO: Implement options() method.
    }

    public static function getBlock(...$args)
    {
        return $args[0]->react_data;
    }

    static function id(...$args)
    {
        // TODO: Implement id() method.
    }
}