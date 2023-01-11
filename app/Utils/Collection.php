<?php


namespace App\Utils;
use Illuminate\Support\Collection as BaseCollection;

class Collection extends BaseCollection
{
    public function __get($key)
    {
        return $this->get($key);
    }

}