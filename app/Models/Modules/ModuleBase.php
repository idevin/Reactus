<?php

namespace App\Models\Modules;


use App\Models\Model;
use App\Models\Permission;
use App\Models\Site;
use Auth;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\Modules\ModuleBase
 *
 * @method static Builder|ModuleBase newModelQuery()
 * @method static Builder|ModuleBase newQuery()
 * @method static Builder|ModuleBase query()
 * @mixin Eloquent
 */
abstract class ModuleBase extends Model
{
    use \App\Traits\Module;

    public string $permissionName = '';

    public static function mapConstants($constant): array
    {
        return array_map(function ($item) {
            return $item['id'];
        }, $constant);
    }

    /**
     * @param Site ...$args [0]
     * @param
     * @return mixed
     */
    abstract static function options(...$args);

    abstract static function id(...$args);

    /**
     * @param bool $strict
     * @return bool
     */
    public function hasPermission(bool $strict = false)
    {
        $user = Auth::user();

        if ($this->permissionName && !empty($this->permissionName)) {
            if ($strict === true) {
                return $user->hasPermission($this->permissionName);
            } else {
                if (!Auth::user() || !Auth::user()->can($this->permissionName, get_class($this))) {
                    return false;
                }
            }
            return true;
        }
        return true;
    }
}