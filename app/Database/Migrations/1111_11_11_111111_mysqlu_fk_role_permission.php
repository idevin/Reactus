<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqluFkRolePermission extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysqlu')->table('role_permission', function (Blueprint $table) {
            if (!Utils::hasForeignKey('role_permission', 'role_permission_permission_id_foreign', 'mysqlu')) {
                $table->foreign('permission_id')->references('id')->on('permission')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('role_permission', 'role_permission_role_id_foreign', 'mysqlu')) {
                $table->foreign('role_id')->references('id')->on('role')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysqlu')->table('role_permission', function (Blueprint $table) {
            $table->dropForeign('role_permission_permission_id_foreign');
            $table->dropForeign('role_permission_role_id_foreign');
        });
    }

}
