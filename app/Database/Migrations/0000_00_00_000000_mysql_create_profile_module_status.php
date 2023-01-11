<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateProfileModuleStatus extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('profile_module_status')) {
            Schema::connection('mysql')->create('profile_module_status', function (Blueprint $table) {
                $table->bigInteger('user_id')->unsigned()->index('profile_module_status_user_id_foreign');
                $table->integer('site_id')->unsigned()->index('profile_module_status_site_id_foreign');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
            });
        } else {
            Schema::connection('mysql')->table('profile_module_status', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('profile_module_status', 'user_id')) {
                    $table->bigInteger('user_id')->unsigned()->index('profile_module_status_user_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('profile_module_status', 'site_id')) {
                    $table->integer('site_id')->unsigned()->index('profile_module_status_site_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('profile_module_status', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('profile_module_status', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
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
        Schema::connection('mysql')->drop('profile_module_status');
    }

}