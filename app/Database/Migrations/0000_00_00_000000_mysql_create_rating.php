<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateRating extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('rating')) {
            Schema::connection('mysql')->create('rating', function (Blueprint $table) {
                $table->increments('id');
                $table->bigInteger('user_id')->unsigned()->index('rating_user_id_foreign');
                $table->integer('object_id')->index('rating_object_id_foreign');
                $table->string('object');
                $table->integer('rating_value');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
            });
        } else {
            Schema::connection('mysql')->table('rating', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('rating', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('rating', 'user_id')) {
                    $table->bigInteger('user_id')->unsigned()->index('rating_user_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('rating', 'object_id')) {
                    $table->integer('object_id')->index('rating_object_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('rating', 'object')) {
                    $table->string('object');
                }
                if (!Schema::connection('mysql')->hasColumn('rating', 'rating_value')) {
                    $table->integer('rating_value');
                }
                if (!Schema::connection('mysql')->hasColumn('rating', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('rating', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
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
        Schema::connection('mysql')->drop('rating');
    }

}