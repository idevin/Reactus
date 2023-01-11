<?php

namespace App\Database\DefaultSeeds;

use App\Models\Domain;
use App\Models\Section;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class Sections extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $data = [
            env('AUTH_DOMAIN') => Domain::DOMAIN_TYPE_THEMATIC,
            env('LOCAL_DOMAIN') => Domain::DOMAIN_TYPE_THEMATIC,
            env('DEFAULT_DOMAIN') => Domain::DOMAIN_TYPE_THEMATIC,
        ];


        foreach ($data as $domainName) {
            $domain = Domain::whereName($domainName)->first();

            $section = Section::roots()->bySite($domain->site->id)->first();

            if (!$section) {

                $user = User::query()->whereUsername('root')->first();

                Section::firstOrCreate([
                    'title' => 'Содержание сайта',
                    'parent_id' => null,
                    'site_id' => $domain->site->id,
                    'user_id' => $user->id
                ]);
            }
        }
    }
}