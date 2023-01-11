<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateProfileModuleInformation extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('profile_module_information')) {
            Schema::connection('mysql')->create('profile_module_information', function (Blueprint $table) {
                $table->bigInteger('user_id')->unsigned()->index('profile_module_information_user_id_foreign');
                $table->integer('site_id')->unsigned()->index('profile_module_information_site_id_foreign');
                $table->text('content')->nullable();
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->increments('id');
            });
        } else {
            Schema::connection('mysql')->table('profile_module_information', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('profile_module_information', 'user_id')) {
                    $table->bigInteger('user_id')->unsigned()->index('profile_module_information_user_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('profile_module_information', 'site_id')) {
                    $table->integer('site_id')->unsigned()->index('profile_module_information_site_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('profile_module_information', 'content')) {
                    $table->text('content')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('profile_module_information', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('profile_module_information', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('profile_module_information', 'id')) {
                    $table->increments('id');
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
        Schema::connection('mysql')->drop('profile_module_information');
    }

}