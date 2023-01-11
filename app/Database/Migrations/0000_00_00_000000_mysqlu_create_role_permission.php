<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqluCreateRolePermission extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysqlu')->hasTable('role_permission')) {
            Schema::connection('mysqlu')->create('role_permission', function (Blueprint $table) {
                $table->integer('permission_id')->unsigned()->index('role_permission_permission_id_foreign');
                $table->integer('role_id')->unsigned()->index('role_permission_role_id_foreign');
                $table->boolean('own')->default("1");
                $table->boolean('other');
            });
        } else {
            Schema::connection('mysqlu')->table('role_permission', function (Blueprint $table) {
                if (!Schema::connection('mysqlu')->hasColumn('role_permission', 'permission_id')) {
                    $table->integer('permission_id')->unsigned()->index('role_permission_permission_id_foreign');
                }
                if (!Schema::connection('mysqlu')->hasColumn('role_permission', 'role_id')) {
                    $table->integer('role_id')->unsigned()->index('role_permission_role_id_foreign');
                }
                if (!Schema::connection('mysqlu')->hasColumn('role_permission', 'own')) {
                    $table->boolean('own')->default("1");
                }
                if (!Schema::connection('mysqlu')->hasColumn('role_permission', 'other')) {
                    $table->boolean('other');
                }
            });
        }
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysqlu')->drop('role_permission');
    }

}