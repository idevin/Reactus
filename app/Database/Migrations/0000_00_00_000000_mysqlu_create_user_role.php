<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqluCreateUserRole extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysqlu')->hasTable('user_role')) {
            Schema::connection('mysqlu')->create('user_role', function (Blueprint $table) {
                $table->integer('role_id')->unsigned()->index('user_role_role_id_foreign');
                $table->bigInteger('user_id')->unsigned()->index('user_role_user_id_foreign');
            });
        } else {
            Schema::connection('mysqlu')->table('user_role', function (Blueprint $table) {
                if (!Schema::connection('mysqlu')->hasColumn('user_role', 'role_id')) {
                    $table->integer('role_id')->unsigned()->index('user_role_role_id_foreign');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_role', 'user_id')) {
                    $table->bigInteger('user_id')->unsigned()->index('user_role_user_id_foreign');
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
        Schema::connection('mysqlu')->drop('user_role');
    }

}