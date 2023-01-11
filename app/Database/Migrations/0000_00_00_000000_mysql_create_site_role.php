<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateSiteRole extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('site_role')) {
            Schema::connection('mysql')->create('site_role', function (Blueprint $table) {
                $table->increments('id');
                $table->bigInteger('user_id')->unsigned()->index('site_role_user_id_foreign');
                $table->integer('role_id')->unsigned()->index('site_role_role_id_foreign');
                $table->integer('site_id')->unsigned()->index('site_role_site_id_foreign');
            });
        } else {
            Schema::connection('mysql')->table('site_role', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('site_role', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('site_role', 'user_id')) {
                    $table->bigInteger('user_id')->unsigned()->index('site_role_user_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('site_role', 'role_id')) {
                    $table->integer('role_id')->unsigned()->index('site_role_role_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('site_role', 'site_id')) {
                    $table->integer('site_id')->unsigned()->index('site_role_site_id_foreign');
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
        Schema::connection('mysql')->drop('site_role');
    }

}