<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateStorageTag extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('storage_tag')) {
            Schema::connection('mysql')->create('storage_tag', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->bigInteger('user_id')->unsigned()->index('storage_tag_user_id_foreign');
                $table->string('slug');
                $table->dateTime('deleted_at')->nullable();
            });
        } else {
            Schema::connection('mysql')->table('storage_tag', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('storage_tag', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('storage_tag', 'name')) {
                    $table->string('name');
                }
                if (!Schema::connection('mysql')->hasColumn('storage_tag', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('storage_tag', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('storage_tag', 'user_id')) {
                    $table->bigInteger('user_id')->unsigned()->index('storage_tag_user_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('storage_tag', 'slug')) {
                    $table->string('slug');
                }
                if (!Schema::connection('mysql')->hasColumn('storage_tag', 'deleted_at')) {
                    $table->dateTime('deleted_at')->nullable();
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
        Schema::connection('mysql')->drop('storage_tag');
    }

}