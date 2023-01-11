<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateLanguage extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('language')) {
            Schema::connection('mysql')->create('language', function (Blueprint $table) {
                $table->increments('id');
                $table->string('alias');
                $table->string('title');
                $table->integer('priority')->default("1");
            });
        } else {
            Schema::connection('mysql')->table('language', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('language', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('language', 'alias')) {
                    $table->string('alias');
                }
                if (!Schema::connection('mysql')->hasColumn('language', 'title')) {
                    $table->string('title');
                }
                if (!Schema::connection('mysql')->hasColumn('language', 'priority')) {
                    $table->integer('priority')->default("1");
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
        Schema::connection('mysql')->drop('language');
    }

}