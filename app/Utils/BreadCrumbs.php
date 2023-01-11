<?php

namespace App\Utils;

class BreadCrumbs
{
    protected $crumbs = [];

    public static function create()
    {
        return new static();
    }

    public function add($title, $route = null)
    {
        $this->crumbs[] += ['route' => $route, 'title' => $title];
    }

    public function get()
    {
        return $this->toArray();
    }

    public function toArray()
    {
        return $this->crumbs;
    }
}
