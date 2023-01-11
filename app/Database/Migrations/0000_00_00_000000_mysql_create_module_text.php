<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateModuleText extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('module_text')) {
            Schema::connection('mysql')->create('module_text', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('site_id')->unsigned()->index('module_text_site_id_foreign');
                $table->boolean('submodule');
                $table->integer('sort_order')->default("1");
                $table->text('content');
                $table->string('name')->nullable();
            });
        } else {
            Schema::connection('mysql')->table('module_text', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('module_text', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('module_text', 'site_id')) {
                    $table->integer('site_id')->unsigned()->index('module_text_site_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('module_text', 'submodule')) {
                    $table->boolean('submodule');
                }
                if (!Schema::connection('mysql')->hasColumn('module_text', 'sort_order')) {
                    $table->integer('sort_order')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('module_text', 'content')) {
                    $table->text('content');
                }
                if (!Schema::connection('mysql')->hasColumn('module_text', 'name')) {
                    $table->string('name')->nullable();
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
        Schema::connection('mysql')->drop('module_text');
    }

}