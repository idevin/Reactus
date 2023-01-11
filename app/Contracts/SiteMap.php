<?php namespace App\Contracts;

use App\Models\Site;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

/**
 * Interface SiteMapAggregatorInterface
 * @package App\Contracts
 */
interface SiteMap
{
    public function getSiteMapDATA(): array;

    /**
     * @param Builder $query
     * @param Site $site
     * @return Collection
     */
    public function scopeGetSiteMapList(Builder $query, Site $site): Collection;
}