<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqluCreateUserSocials extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysqlu')->hasTable('user_socials')) {
            Schema::connection('mysqlu')->create('user_socials', function (Blueprint $table) {
                $table->increments('id');
                $table->bigInteger('user_id')->unsigned()->index('user_socials_user_id_foreign');
                $table->integer('network_id')->index('user_socials_network_id_foreign');
                $table->text('token');
                $table->integer('expires');
                $table->integer('refresh');
                $table->integer('uid')->nullable();
            });
        } else {
            Schema::connection('mysqlu')->table('user_socials', function (Blueprint $table) {
                if (!Schema::connection('mysqlu')->hasColumn('user_socials', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_socials', 'user_id')) {
                    $table->bigInteger('user_id')->unsigned()->index('user_socials_user_id_foreign');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_socials', 'network_id')) {
                    $table->integer('network_id')->index('user_socials_network_id_foreign');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_socials', 'token')) {
                    $table->text('token');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_socials', 'expires')) {
                    $table->integer('expires');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_socials', 'refresh')) {
                    $table->integer('refresh');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_socials', 'uid')) {
                    $table->integer('uid')->nullable();
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
        Schema::connection('mysqlu')->drop('user_socials');
    }

}