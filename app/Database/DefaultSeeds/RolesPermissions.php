<?php

namespace App\Database\DefaultSeeds;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\User;
use App\Models\UserPermission;
use App\Models\UserRole;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Filesystem\Filesystem;
use SimpleXMLElement;

class RolesPermissions extends Seeder
{

    public static array $permissionsArray = [];

    /**
     * Run the database seeds.
     *
     * @return void
     * @throws FileNotFoundException
     */
    public function run()
    {
        Model::unguard();

        $roles = self::parseXml(env('APP_DIR') . DS . 'app' . DS . 'Database' . DS . 'Abac' . DS . 'roles.xml');
        $permissions = self::parseXml(env('APP_DIR') . DS . 'app' . DS . 'Database' . DS . 'Abac' .
            DS . 'permissions.xml');

        $user = User::query()->whereUsername('root')->first();

        foreach ($permissions as $permission) {
            $p = Permission::whereName($permission['name'])->first();
            $permissionData = $permission;

            if (isset($permission['own'])) {
                unset($permission['own']);
            }
            if (isset($permission['other'])) {
                unset($permission['other']);
            }

            if (!$p) {
                $p = Permission::query()->firstOrCreate($permission);
            } else {
                $p->update($permission);
            }

            $uPermission = UserPermission::whereUserId($user->id)->wherePermissionId($p->id)->first();

            if (isset($permission['own'])) {
                $permissionData['own'] = (int)$permission['own'];
            }
            if (isset($permission['other'])) {
                $permissionData['other'] = (int)$permission['other'];
            }

            $userPermission = [
                'user_id' => $user->id,
                'permission_id' => $p->id,
                'own' => $permissionData['own'] ?? 1,
                'other' => $permissionData['other'] ?? 1
            ];

            if (!$uPermission) {
                UserPermission::query()->firstOrCreate($userPermission);
            } else {
                $uPermission->update($userPermission);
            }

            self::$permissionsArray[$p->id] = $p->toArray();

            if (isset($permissionData['own'])) {
                self::$permissionsArray[$p->id]['own'] = (int)$permissionData['own'];
            }

            if (isset($permissionData['other'])) {
                self::$permissionsArray[$p->id]['other'] = (int)$permissionData['other'];
            }
        }

        foreach ($roles as $roleArray) {
            $role = Role::whereName($roleArray['name'])->first();
            if (!$role) {
                $role = Role::query()->firstOrCreate($roleArray);
            } else {
                $role->update($roleArray);
            }

            if ($role->is_root == 1) {
                $userRole = UserRole::query()->whereUserId($user->id)->whereRoleId($role->id)->first();
                if (!$userRole) {
                    UserRole::query()->firstOrCreate([
                        'user_id' => $user->id,
                        'role_id' => $role->id
                    ]);
                }
                self::createPermissions($role, 1, 1);
            }
            if ($role->for_registered == 1) {
                self::createPermissions($role, 1, 0);
            }
            if ($role->is_anon == 1) {
                self::createPermissions($role, 1, 0);
            }
        }
    }

    /**
     * @param $path
     * @return array
     * @throws FileNotFoundException
     */
    public static function parseXml($path): array
    {
        $fs = new Filesystem();

        $data = new SimpleXMLElement($fs->get($path));
        $array = [];
        foreach ($data as $item) {
            $array[] = (array)$item;
        }

        return $array;
    }

    public static function createPermissions($role, $own, $other)
    {
        foreach (self::$permissionsArray as $id => $permission) {
            $rolePermission = RolePermission::query()->whereRoleId($role->id)
                ->wherePermissionId($id)->first();

            $data = [
                'role_id' => $role->id,
                'permission_id' => $id,
                'own' => $own,
                'other' => $other
            ];

            if (isset($permission['own'])) {
                $data['own'] = $permission['own'];
            }

            if (isset($permission['other'])) {
                $data['other'] = $permission['other'];
            }

            if (!$rolePermission) {
                RolePermission::firstOrCreate($data);
            } else {
                RolePermission::where('role_id', $role->id)->where('permission_id', $id)->update($data);
            }
        }
    }
}
