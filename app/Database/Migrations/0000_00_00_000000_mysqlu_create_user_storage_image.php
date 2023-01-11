<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqluCreateUserStorageImage extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysqlu')->hasTable('user_storage_image')) {
            Schema::connection('mysqlu')->create('user_storage_image', function (Blueprint $table) {
                $table->increments('id');
                $table->bigInteger('user_id')->unsigned()->index('user_storage_image_user_id_foreign');
                $table->integer('storage_file_id')->unsigned()->nullable()->index('user_storage_image_storage_file_id_foreign');
                $table->dateTime('deleted_at')->nullable();
                $table->boolean('type');
            });
        } else {
            Schema::connection('mysqlu')->table('user_storage_image', function (Blueprint $table) {
                if (!Schema::connection('mysqlu')->hasColumn('user_storage_image', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_storage_image', 'user_id')) {
                    $table->bigInteger('user_id')->unsigned()->index('user_storage_image_user_id_foreign');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_storage_image', 'storage_file_id')) {
                    $table->integer('storage_file_id')->unsigned()->nullable()->index('user_storage_image_storage_file_id_foreign');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_storage_image', 'deleted_at')) {
                    $table->dateTime('deleted_at')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_storage_image', 'type')) {
                    $table->boolean('type');
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
        Schema::connection('mysqlu')->drop('user_storage_image');
    }

}