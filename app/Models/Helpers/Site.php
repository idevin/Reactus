<?php


namespace App\Models\Helpers;

class Site extends Model
{
    protected static $collection;
    protected static string $collectionClassname = 'App\Models\Site';

    protected static array $loadable = ['setting'];

}