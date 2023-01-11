<?php


namespace App\Helpers\Deployer\Contracts;


use App\Models\DomainVolume;

interface Domain
{
    public static function setup(
        string $domain,
        DomainVolume $pvc,
        bool $isPersonal = false,
        string $customerDomain = ''
    );
}