<?php

namespace App\Contracts;


interface Module
{
    public static function getBlock(...$args);
}