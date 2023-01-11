<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateModuleWorkHours extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('module_work_hours')) {
            Schema::connection('mysql')->create('module_work_hours', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('site_id')->unsigned()->index('module_work_hours_site_id_foreign');
                $table->boolean('show_header')->default("1");
                $table->json('periods');
            });
        } else {
            Schema::connection('mysql')->table('module_work_hours', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('module_work_hours', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('module_work_hours', 'site_id')) {
                    $table->integer('site_id')->unsigned()->index('module_work_hours_site_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('module_work_hours', 'show_header')) {
                    $table->boolean('show_header')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('module_work_hours', 'periods')) {
                    $table->json('periods');
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
        Schema::connection('mysql')->drop('module_work_hours');
    }

}