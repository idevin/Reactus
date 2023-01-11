<?php


namespace App\Helpers\Deployer\Contracts;


interface Command
{
    public static function run(string $cmd);
}