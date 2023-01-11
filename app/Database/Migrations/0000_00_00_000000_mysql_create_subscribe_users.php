<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateSubscribeUsers extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('subscribe_users')) {
            Schema::connection('mysql')->create('subscribe_users', function (Blueprint $table) {
                $table->increments('id');
                $table->bigInteger('subscribed_user_id')->unsigned()->index('subscribe_users_subscribed_user_id_foreign');
                $table->bigInteger('on_user_id')->unsigned()->index('subscribe_users_on_user_id_foreign');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
            });
        } else {
            Schema::connection('mysql')->table('subscribe_users', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('subscribe_users', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('subscribe_users', 'subscribed_user_id')) {
                    $table->bigInteger('subscribed_user_id')->unsigned()->index('subscribe_users_subscribed_user_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('subscribe_users', 'on_user_id')) {
                    $table->bigInteger('on_user_id')->unsigned()->index('subscribe_users_on_user_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('subscribe_users', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('subscribe_users', 'updated_at')) {
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
        Schema::connection('mysql')->drop('subscribe_users');
    }

}