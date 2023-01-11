<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqluCreateUserStatus extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysqlu')->hasTable('user_status')) {
            Schema::connection('mysqlu')->create('user_status', function (Blueprint $table) {
                $table->increments('id');
                $table->bigInteger('user_id')->unsigned()->index('user_status_user_id_foreign');
                $table->string('status');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->integer('user_status_emotion_id')->unsigned()->nullable();
            });
        } else {
            Schema::connection('mysqlu')->table('user_status', function (Blueprint $table) {
                if (!Schema::connection('mysqlu')->hasColumn('user_status', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_status', 'user_id')) {
                    $table->bigInteger('user_id')->unsigned()->index('user_status_user_id_foreign');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_status', 'status')) {
                    $table->string('status');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_status', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_status', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_status', 'user_status_emotion_id')) {
                    $table->integer('user_status_emotion_id')->unsigned()->nullable();
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
        Schema::connection('mysqlu')->drop('user_status');
    }

}