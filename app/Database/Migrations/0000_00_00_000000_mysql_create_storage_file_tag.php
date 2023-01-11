<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateStorageFileTag extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('storage_file_tag')) {
            Schema::connection('mysql')->create('storage_file_tag', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('storage_file_id')->unsigned()->nullable()->index('storage_file_tag_storage_file_id_foreign');
                $table->integer('storage_tag_id')->unsigned()->nullable()->index('storage_file_tag_storage_tag_id_foreign');
            });
        } else {
            Schema::connection('mysql')->table('storage_file_tag', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('storage_file_tag', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('storage_file_tag', 'storage_file_id')) {
                    $table->integer('storage_file_id')->unsigned()->nullable()->index('storage_file_tag_storage_file_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('storage_file_tag', 'storage_tag_id')) {
                    $table->integer('storage_tag_id')->unsigned()->nullable()->index('storage_file_tag_storage_tag_id_foreign');
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
        Schema::connection('mysql')->drop('storage_file_tag');
    }

}