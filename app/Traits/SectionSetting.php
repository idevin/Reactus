<?php

namespace App\Traits;


use App\Models\Section;
use App\Models\SectionSetting as SectionSettingModel;

trait SectionSetting
{
    public static function createSectionSetting(Section $section) {
        $sectionSetting = SectionSettingModel::where(['section_id' => $section->id])->get()->first();
        if (!$sectionSetting) {
            SectionSettingModel::create([
                'section_id' => $section->id
            ]);
        }
    }

}