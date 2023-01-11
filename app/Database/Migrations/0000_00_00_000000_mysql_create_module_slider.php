<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateModuleSlider extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('module_slider')) {
            Schema::connection('mysql')->create('module_slider', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('site_id')->unsigned()->index('module_slider_site_id_foreign');
                $table->string('name')->nullable();
                $table->integer('module_id')->unsigned()->nullable()->index('module_slider_module_id_foreign');
                $table->boolean('view')->default("1");
                $table->boolean('miniature')->default("1");
                $table->boolean('navigation')->default("1");
                $table->boolean('block_type')->default("1");
                $table->boolean('show_statistic')->nullable();
            });
        } else {
            Schema::connection('mysql')->table('module_slider', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('module_slider', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('module_slider', 'site_id')) {
                    $table->integer('site_id')->unsigned()->index('module_slider_site_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('module_slider', 'name')) {
                    $table->string('name')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('module_slider', 'module_id')) {
                    $table->integer('module_id')->unsigned()->nullable()->index('module_slider_module_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('module_slider', 'view')) {
                    $table->boolean('view')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('module_slider', 'miniature')) {
                    $table->boolean('miniature')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('module_slider', 'navigation')) {
                    $table->boolean('navigation')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('module_slider', 'block_type')) {
                    $table->boolean('block_type')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('module_slider', 'show_statistic')) {
                    $table->boolean('show_statistic')->nullable();
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
        Schema::connection('mysql')->drop('module_slider');
    }

}