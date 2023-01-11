<?php

namespace App\Database\DefaultSeeds;

use App\Models\Domain;
use App\Traits\Utils;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class Menus extends Seeder
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
            Utils::createDefaultMenu($domain->site);
        }
    }
}
