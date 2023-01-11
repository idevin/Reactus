<?php


namespace App\Helpers\Deployer;


use App\Helpers\Deployer\Classes\Deploy;
use App\Models\DomainVolume;

class V1 extends Deploy
{
    public static function run(string $cmd)
    {
        parent::run($cmd);
    }

    public static function setup(string $domain, DomainVolume $pvc, bool $isPersonal = false, string $customerDomain = '')
    {
        parent::setup($domain, $pvc, $isPersonal, $customerDomain);
    }

    public static function create()
    {
        parent::create();
    }

    public static function install(DomainVolume $pvc, string $domain): void
    {
        parent::install($pvc, $domain);
    }
}