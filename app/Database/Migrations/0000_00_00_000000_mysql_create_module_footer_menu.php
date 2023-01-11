<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateModuleFooterMenu extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('module_footer_menu')) {
            Schema::connection('mysql')->create('module_footer_menu', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('site_id')->unsigned()->index('module_footer_menu_site_id_foreign');
                $table->boolean('submodule');
                $table->integer('sort_order')->default("1");
                $table->string('name')->nullable();
                $table->text('url');
                $table->json('urls')->nullable();
            });
        } else {
            Schema::connection('mysql')->table('module_footer_menu', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('module_footer_menu', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('module_footer_menu', 'site_id')) {
                    $table->integer('site_id')->unsigned()->index('module_footer_menu_site_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('module_footer_menu', 'submodule')) {
                    $table->boolean('submodule');
                }
                if (!Schema::connection('mysql')->hasColumn('module_footer_menu', 'sort_order')) {
                    $table->integer('sort_order')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('module_footer_menu', 'name')) {
                    $table->string('name')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('module_footer_menu', 'url')) {
                    $table->text('url');
                }
                if (!Schema::connection('mysql')->hasColumn('module_footer_menu', 'urls')) {
                    $table->json('urls')->nullable();
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
        Schema::connection('mysql')->drop('module_footer_menu');
    }

}