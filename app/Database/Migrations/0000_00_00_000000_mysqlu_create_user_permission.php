<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqluCreateUserPermission extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysqlu')->hasTable('user_permission')) {
            Schema::connection('mysqlu')->create('user_permission', function (Blueprint $table) {
                $table->bigInteger('user_id')->unsigned()->index('user_permission_user_id_foreign');
                $table->integer('permission_id')->unsigned()->index('user_permission_permission_id_foreign');
                $table->boolean('own')->default("1");
                $table->boolean('other');
            });
        } else {
            Schema::connection('mysqlu')->table('user_permission', function (Blueprint $table) {
                if (!Schema::connection('mysqlu')->hasColumn('user_permission', 'user_id')) {
                    $table->bigInteger('user_id')->unsigned()->index('user_permission_user_id_foreign');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_permission', 'permission_id')) {
                    $table->integer('permission_id')->unsigned()->index('user_permission_permission_id_foreign');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_permission', 'own')) {
                    $table->boolean('own')->default("1");
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_permission', 'other')) {
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
        Schema::connection('mysqlu')->drop('user_permission');
    }

}