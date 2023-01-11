<?php

use App\Models\Permission;
use Illuminate\Database\Migrations\Migration;

class RemoveUnusedPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $data = [
            'sotrage_access', 'storage_access', 'security_access'
        ];

        $permissions = Permission::query()->whereIn('name', $data)->get();
        if (!empty($permissions)) {
            foreach ($permissions as $permission) {
                $permission->delete();
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
