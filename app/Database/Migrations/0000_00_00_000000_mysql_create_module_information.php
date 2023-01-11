<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateModuleInformation extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('module_information')) {
            Schema::connection('mysql')->create('module_information', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('site_id')->unsigned()->index('module_information_site_id_foreign');
                $table->text('content');
                $table->boolean('block_type')->default("1");
                $table->integer('sort_order')->default("1");
                $table->string('name')->nullable();
                $table->text('react_data')->nullable();
            });
        } else {
            Schema::connection('mysql')->table('module_information', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('module_information', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('module_information', 'site_id')) {
                    $table->integer('site_id')->unsigned()->index('module_information_site_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('module_information', 'content')) {
                    $table->text('content');
                }
                if (!Schema::connection('mysql')->hasColumn('module_information', 'block_type')) {
                    $table->boolean('block_type')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('module_information', 'sort_order')) {
                    $table->integer('sort_order')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('module_information', 'name')) {
                    $table->string('name')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('module_information', 'react_data')) {
                    $table->text('react_data')->nullable();
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
        Schema::connection('mysql')->drop('module_information');
    }

}