<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateModuleLogo extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('module_logo')) {
            Schema::connection('mysql')->create('module_logo', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('site_id')->unsigned()->nullable()->index('module_logo_site_id_foreign');
                $table->integer('sort_order')->default("1");
                $table->string('name')->nullable();
                $table->json('content_options')->nullable();
                $table->json('thumbs')->nullable();
                $table->string('title')->nullable();
                $table->string('description')->nullable();
                $table->integer('storage_file_id')->unsigned()->nullable()->index('module_logo_storage_file_id_foreign');
            });
        } else {
            Schema::connection('mysql')->table('module_logo', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('module_logo', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('module_logo', 'site_id')) {
                    $table->integer('site_id')->unsigned()->nullable()->index('module_logo_site_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('module_logo', 'sort_order')) {
                    $table->integer('sort_order')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('module_logo', 'name')) {
                    $table->string('name')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('module_logo', 'content_options')) {
                    $table->json('content_options')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('module_logo', 'thumbs')) {
                    $table->json('thumbs')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('module_logo', 'title')) {
                    $table->string('title')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('module_logo', 'description')) {
                    $table->string('description')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('module_logo', 'storage_file_id')) {
                    $table->integer('storage_file_id')->unsigned()->nullable()->index('module_logo_storage_file_id_foreign');
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
        Schema::connection('mysql')->drop('module_logo');
    }

}