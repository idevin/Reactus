<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqluCreateUserStatusEmotion extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysqlu')->hasTable('user_status_emotion')) {
            Schema::connection('mysqlu')->create('user_status_emotion', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
            });
        } else {
            Schema::connection('mysqlu')->table('user_status_emotion', function (Blueprint $table) {
                if (!Schema::connection('mysqlu')->hasColumn('user_status_emotion', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_status_emotion', 'name')) {
                    $table->string('name');
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
        Schema::connection('mysqlu')->drop('user_status_emotion');
    }

}