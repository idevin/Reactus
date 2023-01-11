<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateSiteStorageImage extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('site_storage_image')) {
            Schema::connection('mysql')->create('site_storage_image', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('site_id')->unsigned()->index('site_storage_image_site_id_foreign');
                $table->integer('storage_file_id')->unsigned()->nullable()->index('site_storage_image_storage_file_id_foreign');
                $table->dateTime('deleted_at')->nullable();
                $table->boolean('type');
                $table->integer('sort_order');
            });
        } else {
            Schema::connection('mysql')->table('site_storage_image', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('site_storage_image', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('site_storage_image', 'site_id')) {
                    $table->integer('site_id')->unsigned()->index('site_storage_image_site_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('site_storage_image', 'storage_file_id')) {
                    $table->integer('storage_file_id')->unsigned()->nullable()->index('site_storage_image_storage_file_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('site_storage_image', 'deleted_at')) {
                    $table->dateTime('deleted_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('site_storage_image', 'type')) {
                    $table->boolean('type');
                }
                if (!Schema::connection('mysql')->hasColumn('site_storage_image', 'sort_order')) {
                    $table->integer('sort_order');
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
        Schema::connection('mysql')->drop('site_storage_image');
    }

}