<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateLanguageObject extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('language_object')) {
            Schema::connection('mysql')->create('language_object', function (Blueprint $table) {
                $table->increments('id');
                $table->bigInteger('object_id')->index('language_object_object_id_foreign');
                $table->string('object_type');
                $table->integer('language_id')->unsigned()->index('language_object_language_id_foreign');
                $table->string('link');
                $table->string('title');
            });
        } else {
            Schema::connection('mysql')->table('language_object', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('language_object', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('language_object', 'object_id')) {
                    $table->bigInteger('object_id')->index('language_object_object_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('language_object', 'object_type')) {
                    $table->string('object_type');
                }
                if (!Schema::connection('mysql')->hasColumn('language_object', 'language_id')) {
                    $table->integer('language_id')->unsigned()->index('language_object_language_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('language_object', 'link')) {
                    $table->string('link');
                }
                if (!Schema::connection('mysql')->hasColumn('language_object', 'title')) {
                    $table->string('title');
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
        Schema::connection('mysql')->drop('language_object');
    }

}