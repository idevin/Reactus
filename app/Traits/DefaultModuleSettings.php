<?php

namespace App\Traits;


use App\Models\Modules\ModuleContacts;
use App\Models\Modules\ModuleInformation;
use App\Models\Modules\ModuleMenu;
use App\Models\Modules\ModuleFeedback;
use App\Models\Modules\ModuleSettings;
use App\Models\Modules\ModuleSocials;

trait DefaultModuleSettings
{
    public function getDefaultSettings()
    {
        $site = $this->getSite(env('DOMAIN'));
        $defaultSettings = ModuleSettings::where([
            'site_id' => $site->id,
            'default' => 1
        ])->orderBy('sort_order', 'asc')->get();

        $defaultSettings->each(function ($block) {
            ModuleSettings::$positions[ModuleSettings::$positionOptions[$block->position]][] = $block;
        });

        return ModuleSettings::$positions;
    }

    public static function createDefaultModules($site = null)
    {
        $create = function ($object, $position, $sortOrder, $site) {

            $module = \App\Models\Modules\Module::whereClass($object)->get()->first();
            $sortOrder = $sortOrder + 1;

            \App\Models\Modules\ModuleSettings::firstOrCreate([
                'name' => $module->name,
                'module_id' => $module->id,
                'position' => $position,
                'sort_order' => $sortOrder,
                'active' => 1,
                'default' => 1,
                'site_id' => $site->id,
                'object_id' => $site->id,
                'object' => \App\Models\Site::class
            ]);
        };

        $objectsHeader = [
            ModuleMenu::class,
            ModuleInformation::class,
            ModuleFeedback::class
        ];

        $objectsFooter = [
            ModuleSocials::class,
            ModuleContacts::class,
            ModuleFeedback::class
        ];

        if (!$site) {
            $sites = \App\Models\Site::thematic()->get();
        } else {
            $sites = collect()->push($site);
        }

        if (count($sites) > 0) {
            foreach ($sites as $site) {

                foreach ([$objectsHeader, $objectsFooter] as $index => $object) {
                    foreach ($object as $sortOrder => $class) {
                        $position = \App\Models\ModuleSettings::POSITION_HEADER;

                        if (count($object) == $index + 1) {
                            $position = \App\Models\ModuleSettings::POSITION_FOOTER;
                        }
                        $create($class, $position, $sortOrder, $site);
                    }
                }
            }
        }
    }
}