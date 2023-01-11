<?php

namespace App\Providers;

use Exception;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Contracts\Cache\Repository;
use Log;

class PermissionRegistrar
{
    /**
     * @var Gate
     */
    protected Gate $gate;

    /**
     * @var Repository
     */
    protected Repository $cache;

    /**
     * @var string
     */
    protected string $cacheKey = 'permission';

    /**
     * @param Gate $gate
     * @param Repository $cache
     */
    public function __construct(Gate $gate, Repository $cache)
    {
        $this->gate = $gate;
        $this->cache = $cache;
    }

    /**
     *  Register the permissions.
     *
     * @return void
     */
    public function registerPermissions()
    {

    }

    /**
     *  Forget the cached permissions.
     */
    public function forgetCachedPermissions()
    {
    }

    /**
     * Get the current permissions.
     *
     * @return void
     */
    protected function getPermissions()
    {
    }
}
