<?php

use App\Database\DefaultSeeds\AdditionalRolesPermissions;
use App\Database\DefaultSeeds\Languages;
use App\Database\DefaultSeeds\Menus;
use App\Database\DefaultSeeds\Modules;
use App\Database\DefaultSeeds\RolesPermissions;
use App\Database\DefaultSeeds\Sections;
use App\Database\DefaultSeeds\SitesAndDomains;
use App\Database\DefaultSeeds\Templates;
use App\Database\DefaultSeeds\TemplateSchemes;
use App\Database\DefaultSeeds\Users;
use App\Database\DefaultSeeds\UserStatusEmotions;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            Templates::class,
            TemplateSchemes::class,
            Modules::class,
            Languages::class,
            Users::class,
            SitesAndDomains::class,
            RolesPermissions::class,
            Sections::class,
            Menus::class,
            UserStatusEmotions::class
        ]);
    }
}
