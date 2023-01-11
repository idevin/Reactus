<?php

namespace App\Database\DefaultSeeds;

use App\Models\Template;
use App\Traits\Utils;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Filesystem\Filesystem;

class Templates extends Seeder
{
    use Utils;

    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        Model::unguard();

        $array = [
            [
                'name' => 'Статический',
                'default' => 0,
                'alias' => 'StaticLayout',
                'hidden' => 0
            ],
            [
                'name' => 'Лэндинг',
                'default' => 0,
                'alias' => 'LandingLayout',
                'hidden' => 0
            ],
            [
                'name' => 'Selling',
                'default' => 0,
                'alias' => 'SellingLayout',
                'hidden' => 0
            ],
            [
                'name' => 'FreeWay',
                'default' => 0,
                'alias' => 'FreeWayLayout',
                'hidden' => 0
            ],
            [
                'name' => 'Minimal',
                'default' => 1,
                'alias' => 'MinimalLayout',
                'hidden' => 0
            ],
            [
                'name' => 'Oh What',
                'default' => 0,
                'alias' => 'ContinenceLayout',
                'hidden' => 0
            ],
            [
                'name' => 'WebAllod',
                'default' => 0,
                'alias' => 'WeballodLayout',
                'hidden' => 0
            ],
            [
                'name' => 'Sky',
                'default' => 0,
                'alias' => 'SkyLayout',
                'hidden' => 0
            ]
        ];

        foreach ($array as $subArray) {
            self::createTemplate($subArray);
        }
    }

    public static function createTemplateFolder($template)
    {
        $fs = new Filesystem();

        $path = env('PUBLIC_PATH') . DS . '..' . DS . 'views' . DS . 'theme' . DS;
        $defaultPath = $path . 'DefaultLayout';

        if (!$fs->exists($path . $template)) {
            $fs->copyDirectory($defaultPath, $path . $template);

            $pathFile = env('PUBLIC_PATH') . DS . '..' . DS . 'views' . DS;
            $tplFile = $pathFile . $template . '.blade.php';

            if (!$fs->exists($tplFile)) {
                $fs->copy($pathFile . 'DefaultLayout.blade.php', $path . '..' . DS . $template . '.blade.php');
            }
        }
    }

    public static function createTemplate($array)
    {
        $tpl = Template::query()->whereAlias($array['alias'])->first();

        if ($tpl) {
            $tpl->update($array);
        } else {
            Template::firstOrCreate($array);
        }
    }
}
