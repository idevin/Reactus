<?php


namespace App\Models\Helpers;

use Illuminate\Support\Collection;

class Announce extends Model
{
    protected static $collection;
    protected static string $collectionClassname = 'App\Models\Announcement';

    /**
     * @param $siteId
     * @return Collection
     */
    public static function bySite($siteId): Collection
    {
        return static::where('site_id', $siteId);
    }

}