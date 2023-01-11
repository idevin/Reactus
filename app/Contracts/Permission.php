<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface Permission
{
    /**
     * A permission can be applied to roles.
     *
     * @return BelongsToMany
     */
    public function roles();

    /**
     * A permission can be applied to users.
     *
     * @return BelongsToMany
     */
    public function users();

    /**
     * Find a permission by its name.
     *
     * @param string $name
     *
     * @throws PermissionDoesNotExist
     */
    public static function findByName(string $name);
}
