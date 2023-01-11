<?php

namespace App\Models\Helpers;

use Illuminate\Support\Collection;

class Article extends Model
{
    protected static $collection;
    protected static string $collectionClassname = 'App\Models\Article';

    public static function bySection($sectionId): Collection
    {
        return self::getWhere('section_id', $sectionId);
    }
}