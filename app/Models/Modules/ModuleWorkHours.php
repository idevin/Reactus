<?php

namespace App\Models\Modules;

use App\Contracts\Module as ModuleInterface;
use App\Models\Site;
use App\Traits\ModuleAnimationSettings;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\Modules\ModuleWorkHours
 *
 * @property int $id
 * @property int $site_id
 * @property string $content
 * @property int $block_type
 * @property int $sort_order
 * @property string|null $name
 * @property string|null $react_data
 * @property-read mixed $animation_settings
 * @property-read Site $site
 * @method static Builder|ModuleWorkHours newModelQuery()
 * @method static Builder|ModuleWorkHours newQuery()
 * @method static Builder|ModuleWorkHours query()
 * @method static Builder|ModuleWorkHours whereBlockType($value)
 * @method static Builder|ModuleWorkHours whereContent($value)
 * @method static Builder|ModuleWorkHours whereId($value)
 * @method static Builder|ModuleWorkHours whereName($value)
 * @method static Builder|ModuleWorkHours whereReactData($value)
 * @method static Builder|ModuleWorkHours whereSiteId($value)
 * @method static Builder|ModuleWorkHours whereSortOrder($value)
 * @mixin Eloquent
 */
class ModuleWorkHours extends ModuleBase implements ModuleInterface
{
    use ModuleAnimationSettings;

    public $timestamps = false;
    protected $table = 'module_information';
    protected $fillable = [
        'site_id', 'show_header', 'periods', 'sort_order'
    ];

    protected $appends = [
        'animation_settings',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    static function options(...$args)
    {
        // TODO: Implement options() method.
    }

    public static function getBlock(...$args)
    {
        return $args[0]->periods;
    }

    static function id(...$args)
    {
        // TODO: Implement id() method.
    }
}