<?php


namespace App\Helpers\Deployer\Contracts;


use App\Models\DomainVolume;

interface Pvc
{
    public static function create();

    /**
     * Install PVC
     * @param DomainVolume $pvc
     * @param string $domain
     * @return void
     *
     */
    public static function install(DomainVolume $pvc, string $domain): void;
}