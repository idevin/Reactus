<?php

namespace App\Models\Modules;

use App\Contracts\Module as ModuleInterface;


/**
 * App\Models\Modules\ModuleMenuUrl
 *
 * @property int $id
 * @property int $module_menu_id
 * @property string $name
 * @property int $sort_order
 * @property string $url
 * @property-read \App\Models\Modules\ModuleMenu $menu
 * @method static \Illuminate\Database\Eloquent\Builder|ModuleMenuUrl newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ModuleMenuUrl newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ModuleMenuUrl query()
 * @method static \Illuminate\Database\Eloquent\Builder|ModuleMenuUrl whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModuleMenuUrl whereModuleMenuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModuleMenuUrl whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModuleMenuUrl whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModuleMenuUrl whereUrl($value)
 * @mixin \Eloquent
 */
class ModuleMenuUrl extends ModuleBase implements ModuleInterface
{
    public $timestamps = false;
    protected $table = 'module_menu_urls';
    protected $fillable = [
        'name', 'url', 'sort_order', 'module_menu_id'
    ];


    protected $casts = [
        'urls' => 'array'
    ];

    protected $hidden = [
        'module_menu_id'
    ];

    public function menu() {
        return $this->belongsTo(ModuleMenu::class);
    }

    static function options(...$args)
    {
        // TODO: Implement options() method.
    }

    public static function getBlock(...$args)
    {
        // TODO: Implement getBlock() method.
    }

    static function id(...$args)
    {
        // TODO: Implement id() method.
    }
}