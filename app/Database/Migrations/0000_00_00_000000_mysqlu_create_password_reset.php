<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqluCreatePasswordReset extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysqlu')->hasTable('password_reset')) {
            Schema::connection('mysqlu')->create('password_reset', function (Blueprint $table) {
                $table->string('email')->nullable();
                $table->string('token');
                $table->dateTime('created_at')->default(DB::raw("CURRENT_TIMESTAMP"));
                $table->bigInteger('user_id')->unsigned()->index('password_reset_user_id_foreign');
                $table->increments('id');
                $table->string('phone')->nullable();
            });
        } else {
            Schema::connection('mysqlu')->table('password_reset', function (Blueprint $table) {
                if (!Schema::connection('mysqlu')->hasColumn('password_reset', 'email')) {
                    $table->string('email')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('password_reset', 'token')) {
                    $table->string('token');
                }
                if (!Schema::connection('mysqlu')->hasColumn('password_reset', 'created_at')) {
                    $table->dateTime('created_at')->default(DB::raw("CURRENT_TIMESTAMP"));
                }
                if (!Schema::connection('mysqlu')->hasColumn('password_reset', 'user_id')) {
                    $table->bigInteger('user_id')->unsigned()->index('password_reset_user_id_foreign');
                }
                if (!Schema::connection('mysqlu')->hasColumn('password_reset', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysqlu')->hasColumn('password_reset', 'phone')) {
                    $table->string('phone')->nullable();
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
        Schema::connection('mysqlu')->drop('password_reset');
    }

}