<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqluCreateUserSocial extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysqlu')->hasTable('user_social')) {
            Schema::connection('mysqlu')->create('user_social', function (Blueprint $table) {
                $table->increments('id');
                $table->string('uid')->nullable();
                $table->bigInteger('user_id')->unsigned()->index('user_social_user_id_foreign');
                $table->string('token');
                $table->integer('expires')->nullable();
                $table->string('refresh_token')->nullable();
                $table->string('name')->nullable();
                $table->string('email')->nullable();
                $table->string('nickname')->nullable();
                $table->string('provider');
                $table->string('first_name')->nullable();
                $table->string('last_name')->nullable();
            });
        } else {
            Schema::connection('mysqlu')->table('user_social', function (Blueprint $table) {
                if (!Schema::connection('mysqlu')->hasColumn('user_social', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_social', 'uid')) {
                    $table->string('uid')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_social', 'user_id')) {
                    $table->bigInteger('user_id')->unsigned()->index('user_social_user_id_foreign');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_social', 'token')) {
                    $table->string('token');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_social', 'expires')) {
                    $table->integer('expires')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_social', 'refresh_token')) {
                    $table->string('refresh_token')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_social', 'name')) {
                    $table->string('name')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_social', 'email')) {
                    $table->string('email')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_social', 'nickname')) {
                    $table->string('nickname')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_social', 'provider')) {
                    $table->string('provider');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_social', 'first_name')) {
                    $table->string('first_name')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_social', 'last_name')) {
                    $table->string('last_name')->nullable();
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
        Schema::connection('mysqlu')->drop('user_social');
    }

}