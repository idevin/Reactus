<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateModuleMenuUrls extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('module_menu_urls')) {
            Schema::connection('mysql')->create('module_menu_urls', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('module_menu_id')->unsigned()->index('module_menu_urls_module_menu_id_foreign');
                $table->string('name');
                $table->integer('sort_order');
                $table->string('url');
            });
        } else {
            Schema::connection('mysql')->table('module_menu_urls', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('module_menu_urls', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('module_menu_urls', 'module_menu_id')) {
                    $table->integer('module_menu_id')->unsigned()->index('module_menu_urls_module_menu_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('module_menu_urls', 'name')) {
                    $table->string('name');
                }
                if (!Schema::connection('mysql')->hasColumn('module_menu_urls', 'sort_order')) {
                    $table->integer('sort_order');
                }
                if (!Schema::connection('mysql')->hasColumn('module_menu_urls', 'url')) {
                    $table->string('url');
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
        Schema::connection('mysql')->drop('module_menu_urls');
    }

}