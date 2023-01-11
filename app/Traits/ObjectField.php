<?php

namespace App\Traits;

trait ObjectField
{
    public static function tree($nodes, $withEmptyValue = false, $withRoot = true): array
    {
       return Utils::getsubTree($withEmptyValue, $withRoot, $nodes);
    }

}