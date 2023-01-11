<?php

namespace App\Traits;

trait Announcement
{
    public function scopeByObject($query, $objectClass, $objectId = null)
    {
        if (empty($objectClass)) {
            return $query;
        }

        if (empty($objectId)) {
            return $query->whereObjectType($objectClass);
        }

        return $query->whereObjectType($objectClass)->whereObjectId($objectId);
    }

    public function scopeBySite($query, $siteId)
    {
        return $query->whereSiteId($siteId);
    }
}