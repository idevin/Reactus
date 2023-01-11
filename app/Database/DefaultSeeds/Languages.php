<?php

namespace App\Database\DefaultSeeds;

use App\Models\Language;
use App\Traits\Utils;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class Languages extends Seeder
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

        $data = [
            [
                'alias' => 'ru',
                'title' => 'Русский',
                'priority' => 1
            ],
            [
                'alias' => 'en',
                'title' => 'English',
                'priority' => 0
            ]
        ];

        foreach ($data as $language) {
            $exists = Language::whereAlias($language['alias'])->first();
            if (!$exists) {
                Language::firstOrCreate($language);
            } else {
                $exists->update($language);
            }
        }
    }
}
