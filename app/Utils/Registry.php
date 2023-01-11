<?php


namespace App\Utils;

use Exception;
use Illuminate\Support\Collection;

class Registry extends CollectionHelper
{

    public static function set($key, $value): Collection
    {
        return static::getCollection()->put($key, $value);

    }

    public static function get($key)
    {
        return static::getCollection()->get($key);
    }

    /**
     * @param array $array
     * @throws Exception
     */
    public static function collect(array $array = [])
    {
        static::setCollection(collect($array));
    }
}