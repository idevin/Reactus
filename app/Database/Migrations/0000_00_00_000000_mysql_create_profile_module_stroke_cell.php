<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateProfileModuleStrokeCell extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('profile_module_stroke_cell')) {
            Schema::connection('mysql')->create('profile_module_stroke_cell', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('profile_module_stroke_id')->unsigned()->index('profile_module_stroke_cell_profile_module_stroke_id_foreign');
                $table->integer('index');
                $table->integer('profile_module_id')->unsigned()->index('profile_module_stroke_cell_profile_module_id_foreign');
            });
        } else {
            Schema::connection('mysql')->table('profile_module_stroke_cell', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('profile_module_stroke_cell', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('profile_module_stroke_cell', 'profile_module_stroke_id')) {
                    $table->integer('profile_module_stroke_id')->unsigned()->index('profile_module_stroke_cell_profile_module_stroke_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('profile_module_stroke_cell', 'index')) {
                    $table->integer('index');
                }
                if (!Schema::connection('mysql')->hasColumn('profile_module_stroke_cell', 'profile_module_id')) {
                    $table->integer('profile_module_id')->unsigned()->index('profile_module_stroke_cell_profile_module_id_foreign');
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
        Schema::connection('mysql')->drop('profile_module_stroke_cell');
    }

}