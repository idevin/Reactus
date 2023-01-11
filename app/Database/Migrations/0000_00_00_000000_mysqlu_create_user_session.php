<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqluCreateUserSession extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysqlu')->hasTable('user_session')) {
            Schema::connection('mysqlu')->create('user_session', function (Blueprint $table) {
                $table->increments('id');
                $table->bigInteger('user_id')->unsigned()->nullable()->index('user_session_user_id_foreign');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->text('browser');
                $table->text('domain');
                $table->string('ip');
                $table->boolean('status');
                $table->json('location');
                $table->string('oc')->nullable();
                $table->string('browser_string')->nullable();
                $table->string('device_string')->nullable();
                $table->string('location_string')->nullable();
                $table->string('country_string')->nullable();
            });
        } else {
            Schema::connection('mysqlu')->table('user_session', function (Blueprint $table) {
                if (!Schema::connection('mysqlu')->hasColumn('user_session', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_session', 'user_id')) {
                    $table->bigInteger('user_id')->unsigned()->nullable()->index('user_session_user_id_foreign');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_session', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_session', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_session', 'browser')) {
                    $table->text('browser');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_session', 'domain')) {
                    $table->text('domain');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_session', 'ip')) {
                    $table->string('ip');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_session', 'status')) {
                    $table->boolean('status');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_session', 'location')) {
                    $table->json('location');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_session', 'oc')) {
                    $table->string('oc')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_session', 'browser_string')) {
                    $table->string('browser_string')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_session', 'device_string')) {
                    $table->string('device_string')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_session', 'location_string')) {
                    $table->string('location_string')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_session', 'country_string')) {
                    $table->string('country_string')->nullable();
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
        Schema::connection('mysqlu')->drop('user_session');
    }

}