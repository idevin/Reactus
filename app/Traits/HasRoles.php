<?php

namespace App\Traits;

use App\Contracts\PermissionDoesNotExist;
use App\Contracts\Role;
use App\Exceptions\RoleDoesNotExist;
use App\Models\Permission;
use App\Models\Role as RoleModel;
use App\Models\SiteRole;
use Auth;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Log;

trait HasRoles
{
    use HasPermissions;

    public static array $permissions = [];

    /**
     * @param $permission
     * @return ?bool
     */
    public static function canAnon($permission): ?bool
    {
        $permissionExists = null;

        if (Auth::guest()) {

            $roles = RoleModel::whereIsAnon(1)->get();

            if (count($roles) > 0) {
                foreach ($roles as $role) {
                    $permission = $role->permissions()->whereName($permission)->first();

                    if ($permission) {

                        if (env('APP_DEBUG_VARS') == true) {
                            debugvars('GUEST: pemission exists ' . $permission->description);
                        }

                        $permissionExists = true;
                        break;
                    }
                }
            } else {
                $permissionExists = true;
            }
        }

        return $permissionExists;
    }

    /**
     * Scope the user query to certain roles only.
     *
     * @param $query
     * @param string|array|Role|\Illuminate\Support\Collection $roles
     * @return bool
     * @throws RoleDoesNotExist
     */
    public function scopeRole($query, $roles): bool
    {
        if ($roles instanceof Collection) {
            $roles = $roles->toArray();
        }

        if (!is_array($roles)) {
            $roles = [$roles];
        }

        $roles = array_map(function ($role) {
            if ($role instanceof Role) {
                return $role;
            }

            return RoleModel::query()->findByName($role);
        }, $roles);

        return $query->whereHas('roles', function ($query) use ($roles) {
            $query->where(function ($query) use ($roles) {
                foreach ($roles as $role) {
                    $query->orWhere('id', $role->id);
                }
            });
        });
    }

    /**
     * Revoke the given role from the user.
     *
     * @param string|Role|SiteRole $role
     * @throws RoleDoesNotExist
     */
    public function removeRole($role)
    {
        $this->roles()->detach($this->getStoredRole($role));
    }

    /**
     * A user may have multiple roles.
     *
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(
            config('permission.models.role'),
            config('permission.table_names.user_has_roles')
        );
    }

    /**
     * @param $role
     *
     * @return RoleModel|SiteRole
     * @throws RoleDoesNotExist
     */
    protected function getStoredRole($role): RoleModel|SiteRole
    {
        if (is_string($role)) {
            return RoleModel::findByName($role);
        }

        return $role;
    }

    /**
     * Remove all current roles and set the given ones.
     *
     * @param array ...$roles
     *
     * @return $this
     */
    public function syncRoles(...$roles): static
    {
        $this->roles()->detach();

        return $this->assignRole($roles);
    }

    /**
     * Assign the given role to the user.
     *
     * @param array|string|RoleModel ...$roles
     *
     * @return HasRoles
     */
    public function assignRole(...$roles): static
    {
        $roles = collect($roles)
            ->flatten()
            ->map(function ($role) {
                return $this->getStoredRole($role);
            })
            ->all();

        $this->roles()->saveMany($roles);

        return $this;
    }

    /**
     * Determine if the user has any of the given role(s).
     *
     * @param string|array|Role|\Illuminate\Support\Collection $roles
     *
     * @return bool
     */
    public function hasAnyRole($roles): bool
    {
        return $this->hasRole($roles);
    }

    /**
     * Determine if the user has (one of) the given role(s).
     *
     * @param string|array|Role|\Illuminate\Support\Collection $roles
     *
     * @return bool
     */
    public function hasRole($roles): bool
    {
        $result = $this->checkRoles($roles);

        if ($result) {
            return $result;
        }

        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }

            return false;
        }

        return (bool)$roles->intersect($this->roles)->count();
    }

    public function checkRoles($roles): bool|null
    {
        $result = null;

        if (is_string($roles)) {
            $result = $this->roles->contains('name', $roles);
        }

        if ($roles instanceof Role) {
            $result = $this->roles->contains('id', $roles->id);
        }

        return $result;
    }

    /**
     * Determine if the user has all the given role(s).
     *
     * @param string|Role|\Illuminate\Support\Collection $roles
     *
     * @return bool
     */
    public function hasAllRoles($roles): bool
    {
        $result = $this->checkRoles($roles);

        if ($result) {
            return $result;
        }

        $roles = collect()->make($roles)->map(function ($role) {
            return $role instanceof Role ? $role->name : $role;
        });

        return $roles->intersect($this->roles->pluck('name')) === $roles;
    }

    /**
     * Determine if the user may perform the given permission.
     *
     * @param string|Permission $permission
     *
     * @return bool
     * @throws PermissionDoesNotExist
     */
    public function hasPermissionTo($permission): bool
    {
        if (is_string($permission)) {
            $permission = Permission::findByName($permission);
        }

        return $this->hasDirectPermission($permission) || $this->hasPermissionViaRole($permission);
    }

    /**
     * Determine if the user has the given permission.
     *
     * @param string|Permission $permission
     *
     * @return ?bool
     * @throws PermissionDoesNotExist
     */
    public function hasDirectPermission($permission): ?bool
    {
        if (is_string($permission)) {
            $permission = \App\Models\Permission::findByName($permission);

            if (empty($permission)) {
                return false;
            }
        }

        if (empty($this->permissions)) {
            return null;
        }

        return $this->permissions->contains('id', $permission->id);
    }

    /**
     * Determine if the user has, via roles, the given permission.
     *
     * @param Permission $permission
     * @return bool
     */
    public function hasPermissionViaRole(Permission $permission): bool
    {
        return $this->hasRole($permission->roles);
    }

    /**
     *
     * Determine if the user may perform the given permission.
     *
     * @param $ability
     * @return mixed
     */
    public function hasPermission($ability): mixed
    {
        $user = Auth::user();

        if ($user) {
            $site = get_site();
            $permissions = permissions($user, false, null, get_class($site));
            $permissions = collect($permissions);
        } else {
            return collect();
        }

        return $this->getPermission($permissions, $ability);
    }

    /**
     * @param Collection $permissions
     * @param string $ability
     *
     * @return mixed
     */
    protected function getPermission($permissions, $ability): mixed
    {
        return $permissions->filter(function ($permission) use ($ability) {
            return $permission['name'] == $ability;
        })->first();
    }

    public function getPermissionsAttribute(): array
    {

        if (count(static::$permissions) == 0) {
            static::$permissions = remember('permissions_' . session()->getId(), function () {
                $permissions = $this->permissions();
                return $permissions->get()->toArray();
            });
        }

        return static::$permissions;
    }

    /**
     * A user may have multiple direct permissions.
     *
     * @return BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(
            config('permission.models.permission'),
            config('permission.table_names.user_has_permissions')
        )->withPivot(['own', 'other']);
    }
}
