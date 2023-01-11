<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateSiteUser extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('site_user')) {
            Schema::connection('mysql')->create('site_user', function (Blueprint $table) {
                $table->increments('id');
                $table->bigInteger('user_id')->unsigned()->index('site_user_user_id_foreign');
                $table->integer('site_id')->unsigned()->index('site_user_site_id_foreign');
            });
        } else {
            Schema::connection('mysql')->table('site_user', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('site_user', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('site_user', 'user_id')) {
                    $table->bigInteger('user_id')->unsigned()->index('site_user_user_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('site_user', 'site_id')) {
                    $table->integer('site_id')->unsigned()->index('site_user_site_id_foreign');
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
        Schema::connection('mysql')->drop('site_user');
    }

}