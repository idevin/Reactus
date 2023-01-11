<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateSectionStorageImage extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('section_storage_image')) {
            Schema::connection('mysql')->create('section_storage_image', function (Blueprint $table) {
                $table->increments('id');
                $table->bigInteger('section_id')->unsigned()->index('section_storage_image_section_id_foreign');
                $table->integer('storage_file_id')->unsigned()->nullable()->index('section_storage_image_storage_file_id_foreign');
                $table->dateTime('deleted_at')->nullable();
                $table->integer('sort_order');
            });
        } else {
            Schema::connection('mysql')->table('section_storage_image', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('section_storage_image', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('section_storage_image', 'section_id')) {
                    $table->bigInteger('section_id')->unsigned()->index('section_storage_image_section_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('section_storage_image', 'storage_file_id')) {
                    $table->integer('storage_file_id')->unsigned()->nullable()->index('section_storage_image_storage_file_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('section_storage_image', 'deleted_at')) {
                    $table->dateTime('deleted_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('section_storage_image', 'sort_order')) {
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
        Schema::connection('mysql')->drop('section_storage_image');
    }

}