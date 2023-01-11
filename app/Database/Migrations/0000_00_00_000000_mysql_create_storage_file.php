<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateStorageFile extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('storage_file')) {
            Schema::connection('mysql')->create('storage_file', function (Blueprint $table) {
                $table->increments('id');
                $table->bigInteger('user_id')->unsigned()->index('storage_file_user_id_foreign');
                $table->string('filename')->nullable();
                $table->string('type')->nullable();
                $table->integer('size')->nullable();
                $table->string('hash');
                $table->text('url')->nullable();
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->boolean('favorite');
                $table->string('extension')->nullable();
                $table->string('path')->nullable();
                $table->dateTime('deleted_at')->nullable();
                $table->string('title')->nullable();
                $table->text('description')->nullable();
                $table->string('object_type')->nullable();
                $table->string('original_filename')->nullable();
            });
        } else {
            Schema::connection('mysql')->table('storage_file', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('storage_file', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('storage_file', 'user_id')) {
                    $table->bigInteger('user_id')->unsigned()->index('storage_file_user_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('storage_file', 'filename')) {
                    $table->string('filename')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('storage_file', 'type')) {
                    $table->string('type')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('storage_file', 'size')) {
                    $table->integer('size')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('storage_file', 'hash')) {
                    $table->string('hash');
                }
                if (!Schema::connection('mysql')->hasColumn('storage_file', 'url')) {
                    $table->text('url')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('storage_file', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('storage_file', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('storage_file', 'favorite')) {
                    $table->boolean('favorite');
                }
                if (!Schema::connection('mysql')->hasColumn('storage_file', 'extension')) {
                    $table->string('extension')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('storage_file', 'path')) {
                    $table->string('path')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('storage_file', 'deleted_at')) {
                    $table->dateTime('deleted_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('storage_file', 'title')) {
                    $table->string('title')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('storage_file', 'description')) {
                    $table->text('description')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('storage_file', 'object_type')) {
                    $table->string('object_type')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('storage_file', 'original_filename')) {
                    $table->string('original_filename')->nullable();
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
        Schema::connection('mysql')->drop('storage_file');
    }

}