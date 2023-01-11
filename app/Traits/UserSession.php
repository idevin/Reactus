<?php

namespace App\Traits;

trait UserSession
{
    public static function filterParams($objects, $defaultValue, $filterArray)
    {
        $filterArray = json_decode($filterArray);

        if (is_array($filterArray) && count($filterArray) > 0) {
            foreach ($filterArray as $i => $item) {
                if (!in_array($item, $objects)) {
                    unset($filterArray[$i]);
                }
            }
        } else {
            $filterArray = json_decode($defaultValue);
        }

        $filterArray = array_values($filterArray);
        $filterArray = array_filter($filterArray);

        return $filterArray;
    }
}