<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateModuleCatalog extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('module_catalog')) {
            Schema::connection('mysql')->create('module_catalog', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('site_id')->unsigned()->index('module_catalog_site_id_foreign');
                $table->string('sort_order')->default("desc");
                $table->string('name')->nullable();
                $table->integer('module_id')->unsigned()->nullable()->index('module_catalog_module_id_foreign');
                $table->text('filter_settings')->nullable();
                $table->text('sort_options')->nullable();
                $table->integer('object_id')->index('module_catalog_object_id_foreign');
                $table->string('sort_by')->default("views");
                $table->boolean('hide_filter')->nullable();
            });
        } else {
            Schema::connection('mysql')->table('module_catalog', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('module_catalog', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('module_catalog', 'site_id')) {
                    $table->integer('site_id')->unsigned()->index('module_catalog_site_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('module_catalog', 'sort_order')) {
                    $table->string('sort_order')->default("desc");
                }
                if (!Schema::connection('mysql')->hasColumn('module_catalog', 'name')) {
                    $table->string('name')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('module_catalog', 'module_id')) {
                    $table->integer('module_id')->unsigned()->nullable()->index('module_catalog_module_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('module_catalog', 'filter_settings')) {
                    $table->text('filter_settings')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('module_catalog', 'sort_options')) {
                    $table->text('sort_options')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('module_catalog', 'object_id')) {
                    $table->integer('object_id')->index('module_catalog_object_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('module_catalog', 'sort_by')) {
                    $table->string('sort_by')->default("views");
                }
                if (!Schema::connection('mysql')->hasColumn('module_catalog', 'hide_filter')) {
                    $table->boolean('hide_filter')->nullable();
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
        Schema::connection('mysql')->drop('module_catalog');
    }

}