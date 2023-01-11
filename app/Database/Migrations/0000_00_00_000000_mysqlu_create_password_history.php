<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqluCreatePasswordHistory extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysqlu')->hasTable('password_history')) {
            Schema::connection('mysqlu')->create('password_history', function (Blueprint $table) {
                $table->increments('id');
                $table->string('password_hash');
                $table->boolean('reset_via');
                $table->bigInteger('user_id')->unsigned()->index('password_history_user_id_foreign');
            });
        } else {
            Schema::connection('mysqlu')->table('password_history', function (Blueprint $table) {
                if (!Schema::connection('mysqlu')->hasColumn('password_history', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysqlu')->hasColumn('password_history', 'password_hash')) {
                    $table->string('password_hash');
                }
                if (!Schema::connection('mysqlu')->hasColumn('password_history', 'reset_via')) {
                    $table->boolean('reset_via');
                }
                if (!Schema::connection('mysqlu')->hasColumn('password_history', 'user_id')) {
                    $table->bigInteger('user_id')->unsigned()->index('password_history_user_id_foreign');
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
        Schema::connection('mysqlu')->drop('password_history');
    }

}