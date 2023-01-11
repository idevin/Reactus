<?php

namespace App\Contracts;


interface Social
{
    public function index();

    public function callback();

    public function getConfig();

    public function getProvider();

    public function getScopes();
}