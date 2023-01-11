<?php namespace App\Traits;

use App\Models\Modules\Module;
use App\Models\Modules\ModuleAnimationSettings as Settings;

/**
 * Class ModuleAnimationSettings
 * @package App\Traits
 */
trait ModuleAnimationSettings
{
    public function getAnimationSettingsAttribute()
    {
        $moduleTemplate = Module::query()->where('class', static::class)->first();
        if (empty($moduleTemplate)) {
            return [];
        }

        $settings = Settings::query()->where('module_id', $this->attributes['id'])
            ->where('module_template_id', $moduleTemplate->id)->first();

        if (empty($settings)) {
            return Settings::ANIMATE_SETTINGS;
        }

        return $settings->settings;
    }
}