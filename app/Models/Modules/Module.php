<?php

namespace App\Models\Modules;

use App\Models\Model;
use App\Models\TemplatePrototypeStrokeModule;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Route;
use stdClass;

/**
 * App\Models\Modules\Module
 *
 * @property int $id
 * @property string $name
 * @property string $class
 * @property-read mixed $module_id
 * @property-read mixed $url
 * @method static Builder|Module newModelQuery()
 * @method static Builder|Module newQuery()
 * @method static Builder|Module query()
 * @method static Builder|Module whereClass($value)
 * @method static Builder|Module whereId($value)
 * @method static Builder|Module whereName($value)
 * @method static firstOrCreate($array)
 * @mixin Eloquent
 */
class Module extends Model
{
    public $timestamps = false;
    protected $table = 'module';
    protected $fillable = [
        'name', 'class'
    ];

    protected $appends = ['url', 'module_id'];

    public static function getModules(): Collection|array
    {
        return self::query()->orderBy('name', 'ASC')->get();
    }

    public static function getSelect(): array
    {
        $modules = self::query()->orderBy('name')->get()->pluck('name', 'id')->toArray();
        return [null => 'Выберите модуль...'] + $modules;
    }

    public function getUrlAttribute(): stdClass
    {
        $routeCollection = Route::getRoutes();
        $routes = $routeCollection->getRoutes();
        $name = $this->class;

        $allData = new stdClass();
        $allData->data = new stdClass();

        $groupedRoutes = array_map(function ($route) use ($name, $allData) {
            $action = $route->getName();

            if (isset($action)) {

                preg_match('/(' . addcslashes($name, '\\') . ')\.(\w+)/', $action, $matches);
                if (!empty($matches) && count($matches) == 3) {

                    $o = new stdClass();
                    $o->{$matches[2]} = route($matches[0], [], false);
                    $allData->data = $o;
                    return $o;
                }
            }
            return null;
        }, $routes);

        $groupedRoutes = array_values(array_filter($groupedRoutes));

        foreach ($groupedRoutes as $groupedRoute) {
            foreach ($groupedRoute as $oIndex => $sGroupedRoute) {
                $allData->data->$oIndex = $sGroupedRoute;
            }
        }

        return $allData->data;
    }

    public function getModuleIdAttribute(): int
    {
        return $this->id;
    }

    public function modulePrototype(): HasOne
    {
        return $this->hasOne(TemplatePrototypeStrokeModule::class);
    }
}
