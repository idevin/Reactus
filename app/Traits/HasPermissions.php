<?php

namespace App\Traits;

use App\Contracts\Permission;
use App\Models\Permission as PermissionModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait HasPermissions
{
    /**
     * Grant the given permission(s) to a role.
     *
     * @param string|array|Permission|Collection $permissions
     *
     * @return HasPermissions
     */
    public function givePermissionTo(...$permissions)
    {
        $permissions = collect($permissions)
            ->flatten()
            ->map(function ($permission) {
                return $this->getStoredPermission($permission);
            })
            ->all();

        $this->permissions()->saveMany($permissions);

        return $this;
    }

    /**
     * Remove all current permissions and set the given ones.
     *
     * @param array ...$permissions
     *
     * @return $this
     */
    public function syncPermissions(...$permissions)
    {
        $this->permissions()->detach();

        return $this->givePermissionTo($permissions);
    }

    /**
     * Revoke the given permission.
     *
     * @param $permission
     *
     * @return HasPermissions
     */
    public function revokePermissionTo($permission)
    {
        $this->permissions()->detach($this->getStoredPermission($permission));

        return $this;
    }

    /**
     * @param string|array|Permission|Collection $permissions
     *
     * @return Permission|PermissionModel|Model|Collection
     */
    protected function getStoredPermission($permissions)
    {
        if (is_string($permissions)) {
            return PermissionModel::findByName($permissions);
        }

        if (is_array($permissions)) {
            return (new \App\Models\Permission)->whereIn('name', $permissions)->get();
        }

        return $permissions;
    }
}
