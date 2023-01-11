<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateProfileModuleStatistics extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('profile_module_statistics')) {
            Schema::connection('mysql')->create('profile_module_statistics', function (Blueprint $table) {
                $table->increments('id');
                $table->bigInteger('user_id')->unsigned()->index('profile_module_statistics_user_id_foreign');
                $table->integer('site_id')->unsigned()->index('profile_module_statistics_site_id_foreign');
            });
        } else {
            Schema::connection('mysql')->table('profile_module_statistics', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('profile_module_statistics', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('profile_module_statistics', 'user_id')) {
                    $table->bigInteger('user_id')->unsigned()->index('profile_module_statistics_user_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('profile_module_statistics', 'site_id')) {
                    $table->integer('site_id')->unsigned()->index('profile_module_statistics_site_id_foreign');
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
        Schema::connection('mysql')->drop('profile_module_statistics');
    }

}