<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqluCreateUser extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysqlu')->hasTable('user')) {
            Schema::connection('mysqlu')->create('user', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('username');
                $table->string('email')->nullable();
                $table->string('phone')->nullable();
                $table->string('phone_work')->nullable();
                $table->string('phone_home')->nullable();
                $table->string('auth_token');
                $table->string('domain');
                $table->string('password');
                $table->boolean('superadmin')->unsigned();
                $table->boolean('active')->unsigned();
                $table->string('remember_token')->nullable();
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->dateTime('birthday')->nullable();
                $table->integer('native_city_id')->nullable()->index('user_native_city_id_foreign');
                $table->integer('marital_status_id')->unsigned()->nullable()->index('user_marital_status_id_foreign');
                $table->integer('work_place_id')->unsigned()->nullable()->index('user_work_place_id_foreign');
                $table->integer('address_id')->unsigned()->nullable()->index('user_address_id_foreign');
                $table->string('website')->nullable();
                $table->string('first_name')->nullable();
                $table->string('last_name')->nullable();
                $table->string('middle_name')->nullable();
                $table->string('sex')->nullable();
                $table->string('password_new')->nullable();
                $table->boolean('visibility')->nullable();
                $table->string('status')->nullable();
                $table->integer('parent_id')->nullable()->index('user_parent_id_foreign');
                $table->bigInteger('rating');
                $table->string('image')->nullable();
                $table->boolean('locked');
                $table->dateTime('last_login')->nullable();
                $table->dateTime('last_logout')->nullable();
                $table->bigInteger('user_status_id')->unsigned()->nullable()->index('user_user_status_id_foreign');
                $table->integer('language_id')->unsigned()->nullable()->index('user_language_id_foreign');
                $table->string('card_brand')->nullable();
                $table->string('card_last_four')->nullable();
                $table->dateTime('trial_ends_at')->nullable();
                $table->integer('balance');
                $table->boolean('autorenew');
                $table->boolean('admin_access');
                $table->dateTime('last_password_update')->nullable();
            });
        } else {
            Schema::connection('mysqlu')->table('user', function (Blueprint $table) {
                if (!Schema::connection('mysqlu')->hasColumn('user', 'id')) {
                    $table->bigIncrements('id');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user', 'username')) {
                    $table->string('username');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user', 'email')) {
                    $table->string('email')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('user', 'phone')) {
                    $table->string('phone')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('user', 'phone_work')) {
                    $table->string('phone_work')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('user', 'phone_home')) {
                    $table->string('phone_home')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('user', 'auth_token')) {
                    $table->string('auth_token');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user', 'domain')) {
                    $table->string('domain');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user', 'password')) {
                    $table->string('password');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user', 'superadmin')) {
                    $table->boolean('superadmin')->unsigned();
                }
                if (!Schema::connection('mysqlu')->hasColumn('user', 'active')) {
                    $table->boolean('active')->unsigned();
                }
                if (!Schema::connection('mysqlu')->hasColumn('user', 'remember_token')) {
                    $table->string('remember_token')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('user', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('user', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('user', 'birthday')) {
                    $table->dateTime('birthday')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('user', 'native_city_id')) {
                    $table->integer('native_city_id')->nullable()->index('user_native_city_id_foreign');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user', 'marital_status_id')) {
                    $table->integer('marital_status_id')->unsigned()->nullable()->index('user_marital_status_id_foreign');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user', 'work_place_id')) {
                    $table->integer('work_place_id')->unsigned()->nullable()->index('user_work_place_id_foreign');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user', 'address_id')) {
                    $table->integer('address_id')->unsigned()->nullable()->index('user_address_id_foreign');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user', 'website')) {
                    $table->string('website')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('user', 'first_name')) {
                    $table->string('first_name')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('user', 'last_name')) {
                    $table->string('last_name')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('user', 'middle_name')) {
                    $table->string('middle_name')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('user', 'sex')) {
                    $table->string('sex')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('user', 'password_new')) {
                    $table->string('password_new')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('user', 'visibility')) {
                    $table->boolean('visibility')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('user', 'status')) {
                    $table->string('status')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('user', 'parent_id')) {
                    $table->integer('parent_id')->nullable()->index('user_parent_id_foreign');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user', 'rating')) {
                    $table->bigInteger('rating');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user', 'image')) {
                    $table->string('image')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('user', 'locked')) {
                    $table->boolean('locked');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user', 'last_login')) {
                    $table->dateTime('last_login')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('user', 'last_logout')) {
                    $table->dateTime('last_logout')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('user', 'user_status_id')) {
                    $table->bigInteger('user_status_id')->unsigned()->nullable()->index('user_user_status_id_foreign');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user', 'language_id')) {
                    $table->integer('language_id')->unsigned()->nullable()->index('user_language_id_foreign');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user', 'card_brand')) {
                    $table->string('card_brand')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('user', 'card_last_four')) {
                    $table->string('card_last_four')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('user', 'trial_ends_at')) {
                    $table->dateTime('trial_ends_at')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('user', 'balance')) {
                    $table->integer('balance');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user', 'autorenew')) {
                    $table->boolean('autorenew');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user', 'admin_access')) {
                    $table->boolean('admin_access');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user', 'last_password_update')) {
                    $table->dateTime('last_password_update')->nullable();
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
        Schema::connection('mysqlu')->drop('user');
    }

}