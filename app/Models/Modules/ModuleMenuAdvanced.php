<?php

namespace App\Models\Modules;

use App\Contracts\Module as ModuleInterface;
use App\Models\Site;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static create(array $array)
 */
class ModuleMenuAdvanced extends ModuleBase implements ModuleInterface
{
    use \App\Traits\Module;

    protected $table = 'module_menu_advanced';

    public string $permissionName = 'site_menu_horizontal_manage';

    public $connection = 'mysql';

    protected $fillable = ['name', 'site_id', 'sort_order', 'content_options'];

    public static array $types = [
        1 => 'URL',
        2 => 'Anchor'
    ];

    public $timestamps = false;

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function urls(): HasMany
    {
        return $this->hasMany(ModuleMenuAdvancedUrl::class, 'module_menu_advanced_id');
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
