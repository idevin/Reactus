<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqluCreateUserSite extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysqlu')->hasTable('user_site')) {
            Schema::connection('mysqlu')->create('user_site', function (Blueprint $table) {
                $table->increments('id');
                $table->bigInteger('user_id')->unsigned()->index('user_site_user_id_foreign');
                $table->integer('site_id')->unsigned()->nullable()->index('user_site_site_id_foreign');
                $table->boolean('logged');
                $table->integer('domain_id')->unsigned()->nullable()->index('user_site_domain_id_foreign');
                $table->boolean('admin')->nullable();
            });
        } else {
            Schema::connection('mysqlu')->table('user_site', function (Blueprint $table) {
                if (!Schema::connection('mysqlu')->hasColumn('user_site', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_site', 'user_id')) {
                    $table->bigInteger('user_id')->unsigned()->index('user_site_user_id_foreign');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_site', 'site_id')) {
                    $table->integer('site_id')->unsigned()->nullable()->index('user_site_site_id_foreign');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_site', 'logged')) {
                    $table->boolean('logged');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_site', 'domain_id')) {
                    $table->integer('domain_id')->unsigned()->nullable()->index('user_site_domain_id_foreign');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_site', 'admin')) {
                    $table->boolean('admin')->nullable();
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
        Schema::connection('mysqlu')->drop('user_site');
    }

}