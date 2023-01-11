<?php

namespace App\Models\Modules;

use App\Contracts\Module as ModuleInterface;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\Modules\ModuleSlideOptions
 *
 * @property int $id
 * @property int $sort_order
 * @property int $module_slide_id
 * @property-read \App\Models\Modules\ModuleSlide $moduleSlide
 * @method static Builder|\App\Models\Modules\ModuleSlideOptions newModelQuery()
 * @method static Builder|\App\Models\Modules\ModuleSlideOptions newQuery()
 * @method static Builder|\App\Models\Modules\ModuleSlideOptions query()
 * @method static Builder|\App\Models\Modules\ModuleSlideOptions whereId($value)
 * @method static Builder|\App\Models\Modules\ModuleSlideOptions whereModuleSlideId($value)
 * @method static Builder|\App\Models\Modules\ModuleSlideOptions whereSortOrder($value)
 * @mixin Eloquent
 */
class ModuleSlideOptions extends ModuleBase implements ModuleInterface
{
    public $timestamps = false;
    protected $table = 'module_slide_options';
    protected $fillable = [
        'sort_order', 'module_slide_id'
    ];

    public function moduleSlide()
    {
        return $this->belongsTo(ModuleSlide::class);
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