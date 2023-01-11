<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateModuleMenu extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('module_menu')) {
            Schema::connection('mysql')->create('module_menu', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('site_id')->unsigned()->index('module_menu_site_id_foreign');
                $table->string('name');
                $table->text('url');
                $table->integer('sort_order')->default("1");
                $table->boolean('submodule');
                $table->json('settings')->nullable();
                $table->json('content_options')->nullable();
            });
        } else {
            Schema::connection('mysql')->table('module_menu', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('module_menu', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('module_menu', 'site_id')) {
                    $table->integer('site_id')->unsigned()->index('module_menu_site_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('module_menu', 'name')) {
                    $table->string('name');
                }
                if (!Schema::connection('mysql')->hasColumn('module_menu', 'url')) {
                    $table->text('url');
                }
                if (!Schema::connection('mysql')->hasColumn('module_menu', 'sort_order')) {
                    $table->integer('sort_order')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('module_menu', 'submodule')) {
                    $table->boolean('submodule');
                }
                if (!Schema::connection('mysql')->hasColumn('module_menu', 'settings')) {
                    $table->json('settings')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('module_menu', 'content_options')) {
                    $table->json('content_options')->nullable();
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
        Schema::connection('mysql')->drop('module_menu');
    }

}