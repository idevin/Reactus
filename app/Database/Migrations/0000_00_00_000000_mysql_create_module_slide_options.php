<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateModuleSlideOptions extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('module_slide_options')) {
            Schema::connection('mysql')->create('module_slide_options', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('sort_order')->default("1");
                $table->integer('module_slide_id')->unsigned()->index('module_slide_options_module_slide_id_foreign');
            });
        } else {
            Schema::connection('mysql')->table('module_slide_options', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('module_slide_options', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('module_slide_options', 'sort_order')) {
                    $table->integer('sort_order')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('module_slide_options', 'module_slide_id')) {
                    $table->integer('module_slide_id')->unsigned()->index('module_slide_options_module_slide_id_foreign');
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
        Schema::connection('mysql')->drop('module_slide_options');
    }

}