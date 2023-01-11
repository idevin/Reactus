<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateModuleMenuAdvanced extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('module_menu_advanced')) {
            Schema::connection('mysql')->create('module_menu_advanced', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->json('content_options')->nullable();
                $table->integer('site_id')->unsigned()->index('module_menu_advanced_site_id_foreign');
                $table->integer('sort_order')->default("1");
                $table->dateTime('updated_at')->nullable();
            });
        } else {
            Schema::connection('mysql')->table('module_menu_advanced', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('module_menu_advanced', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('module_menu_advanced', 'name')) {
                    $table->string('name');
                }
                if (!Schema::connection('mysql')->hasColumn('module_menu_advanced', 'content_options')) {
                    $table->json('content_options')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('module_menu_advanced', 'site_id')) {
                    $table->integer('site_id')->unsigned()->index('module_menu_advanced_site_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('module_menu_advanced', 'sort_order')) {
                    $table->integer('sort_order')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('module_menu_advanced', 'updated_at')) {
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
        Schema::connection('mysql')->drop('module_menu_advanced');
    }

}