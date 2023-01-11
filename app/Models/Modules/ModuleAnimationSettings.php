<?php namespace App\Models\Modules;

use App\Contracts\Module as ModuleInterface;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class ModuleAnimationSettings
 *
 * @package App\Models\Modules
 * @property int $id
 * @property string $settings
 * @property int $module_id
 * @property int $module_template_id
 * @method static Builder|ModuleAnimationSettings newModelQuery()
 * @method static Builder|ModuleAnimationSettings newQuery()
 * @method static Builder|ModuleAnimationSettings query()
 * @method static Builder|ModuleAnimationSettings whereId($value)
 * @method static Builder|ModuleAnimationSettings whereModuleId($value)
 * @method static Builder|ModuleAnimationSettings whereModuleTemplateId($value)
 * @method static Builder|ModuleAnimationSettings whereSettings($value)
 * @mixin Eloquent
 */
class ModuleAnimationSettings extends ModuleBase implements ModuleInterface
{
    const ANIMATE_SETTINGS = [
        'type' => 0,
        'delay' => 0,
        'duration' => 1000,
        'side' => 0,
    ];
    public $timestamps = false;
    public $table = 'module_animation_settings';
    public $fillable = [
        'settigns',
        'module_template_id',
        'module_id',
    ];

    public $appends = [
        'settings',
    ];

    public function setSettingsAttribute($arSettings)
    {
        if (empty($arSettings)) {
            $this->attributes['settings'] = json_encode(self::ANIMATE_SETTINGS[0]);

            return;
        }

        $this->attributes['settings'] = json_encode($arSettings);
    }

    public function getSettingsAttribute()
    {
        $arResult = json_decode($this->attributes['settings'], true);
        if (empty($arResult)) {
            return self::ANIMATE_SETTINGS;
        }

        return $arResult;
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