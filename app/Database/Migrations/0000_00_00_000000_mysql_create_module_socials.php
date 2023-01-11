<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateModuleSocials extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('module_socials')) {
            Schema::connection('mysql')->create('module_socials', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('site_id')->unsigned()->index('module_socials_site_id_foreign');
                $table->integer('sort_order')->default("1");
                $table->string('name')->nullable();
            });
        } else {
            Schema::connection('mysql')->table('module_socials', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('module_socials', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('module_socials', 'site_id')) {
                    $table->integer('site_id')->unsigned()->index('module_socials_site_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('module_socials', 'sort_order')) {
                    $table->integer('sort_order')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('module_socials', 'name')) {
                    $table->string('name')->nullable();
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
        Schema::connection('mysql')->drop('module_socials');
    }

}