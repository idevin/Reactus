<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateActivityLanguage extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('activity_language')) {
            Schema::connection('mysql')->create('activity_language', function (Blueprint $table) {
                $table->increments('id');
                $table->string('activity_key')->nullable();
                $table->string('translated')->nullable();
                $table->string('lang');
            });
        } else {
            Schema::connection('mysql')->table('activity_language', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('activity_language', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('activity_language', 'activity_key')) {
                    $table->string('activity_key')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('activity_language', 'translated')) {
                    $table->string('translated')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('activity_language', 'lang')) {
                    $table->string('lang');
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
        Schema::connection('mysql')->drop('activity_language');
    }

}