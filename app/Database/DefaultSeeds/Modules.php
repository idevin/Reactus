<?php

namespace App\Database\DefaultSeeds;

use App\Models\Modules\Module;
use App\Models\Modules\ModuleArticle;
use App\Models\Modules\ModuleCatalog;
use App\Models\Modules\ModuleComment;
use App\Models\Modules\ModuleCompetitiveAdvantages;
use App\Models\Modules\ModuleContacts;
use App\Models\Modules\ModuleFeedback;
use App\Models\Modules\ModuleInformation;
use App\Models\Modules\ModuleLogo;
use App\Models\Modules\ModuleMenu;
use App\Models\Modules\ModuleMenuAdvanced;
use App\Models\Modules\ModuleSection;
use App\Models\Modules\ModuleSlider;
use App\Models\Modules\ModuleSlogan;
use App\Models\Modules\ModuleSocials;
use App\Models\Modules\ModuleStatistics;
use App\Models\Modules\ModuleText;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class Modules extends Seeder
{
    public function run()
    {
        Model::unguard();


        $data = [
            [
                'name' => 'Логотип',
                'class' => ModuleLogo::class
            ],
            [
                'name' => 'Слоган',
                'class' => ModuleSlogan::class
            ],
            [
                'name' => 'Горизонтальное меню',
                'class' => ModuleMenu::class
            ],
            [
                'name' => 'Информация',
                'class' => ModuleInformation::class
            ],
            [
                'name' => 'Контакты',
                'class' => ModuleContacts::class
            ],
            [
                'name' => 'Слайдер',
                'class' => ModuleSlider::class
            ],
            [
                'name' => 'Социальные сети',
                'class' => ModuleSocials::class
            ],
            [
                'name' => 'Статистика',
                'class' => ModuleStatistics::class
            ],
            [
                'name' => 'Статьи',
                'class' => ModuleArticle::class
            ],
            [
                'name' => 'Слоган',
                'class' => ModuleSlogan::class
            ],
            [
                'name' => 'Разделы',
                'class' => ModuleSection::class
            ],
            [
                'name' => 'Слоган',
                'class' => ModuleSlogan::class
            ],
            [
                'name' => 'Комментарии',
                'class' => ModuleComment::class
            ],
            [
                'name' => 'Меню',
                'class' => ModuleMenu::class
            ],
            [
                'name' => 'Текст',
                'class' => ModuleText::class
            ],
            [
                'name' => 'Обратная связь',
                'class' => ModuleFeedback::class
            ],
            [
                'name' => 'Каталог',
                'class' => ModuleCatalog::class
            ],
            [
                'name' => 'Блок преимуществ',
                'class' => ModuleCompetitiveAdvantages::class
            ],
            [
                'name' => 'Меню расширенное',
                'class' => ModuleMenuAdvanced::class
            ]
        ];

        foreach ($data as $module) {
            self::createModule($module);
        }
    }

    public static function createModule($array)
    {
        $m = Module::query()->whereClass($array['class'])->first();

        if ($m) {
            $m->update($array);
        } else {
            Module::firstOrCreate($array);
        }
    }
}
