<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateModuleMenuAdvancedUrls extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('module_menu_advanced_urls')) {
            Schema::connection('mysql')->create('module_menu_advanced_urls', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('module_menu_advanced_id')->unsigned()->index('module_menu_advanced_urls_module_menu_advanced_id_foreign');
                $table->string('name')->nullable();
                $table->string('url');
                $table->integer('parent_id')->nullable()->index('module_menu_advanced_urls_parent_id_foreign');
                $table->integer('lft')->nullable();
                $table->integer('rgt')->nullable();
                $table->integer('depth')->nullable();
                $table->string('image')->nullable();
                $table->integer('sort_order')->default("1");
                $table->boolean('disabled');
            });
        } else {
            Schema::connection('mysql')->table('module_menu_advanced_urls', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('module_menu_advanced_urls', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('module_menu_advanced_urls', 'module_menu_advanced_id')) {
                    $table->integer('module_menu_advanced_id')->unsigned()->index('module_menu_advanced_urls_module_menu_advanced_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('module_menu_advanced_urls', 'name')) {
                    $table->string('name')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('module_menu_advanced_urls', 'url')) {
                    $table->string('url');
                }
                if (!Schema::connection('mysql')->hasColumn('module_menu_advanced_urls', 'parent_id')) {
                    $table->integer('parent_id')->nullable()->index('module_menu_advanced_urls_parent_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('module_menu_advanced_urls', 'lft')) {
                    $table->integer('lft')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('module_menu_advanced_urls', 'rgt')) {
                    $table->integer('rgt')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('module_menu_advanced_urls', 'depth')) {
                    $table->integer('depth')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('module_menu_advanced_urls', 'image')) {
                    $table->string('image')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('module_menu_advanced_urls', 'sort_order')) {
                    $table->integer('sort_order')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('module_menu_advanced_urls', 'disabled')) {
                    $table->boolean('disabled');
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
        Schema::connection('mysql')->drop('module_menu_advanced_urls');
    }

}