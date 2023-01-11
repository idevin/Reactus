<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateLanguageObjectGroup extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('language_object_group')) {
            Schema::connection('mysql')->create('language_object_group', function (Blueprint $table) {
                        $table->increments('id');
        $table->integer('language_id')->unsigned()->nullable()->index('language_object_group_language_id_foreign');
        $table->integer('language_object_id')->unsigned()->nullable()->index('language_object_group_language_object_id_foreign');
        $table->integer('mapped_id')->index('language_object_group_mapped_id_foreign');
            });
        } else {
            Schema::connection('mysql')->table('language_object_group', function (Blueprint $table) {
                        if (!Schema::connection('mysql')->hasColumn('language_object_group', 'id')) {
                        $table->increments('id');
        }
        if (!Schema::connection('mysql')->hasColumn('language_object_group', 'language_id')) {
                        $table->integer('language_id')->unsigned()->nullable()->index('language_object_group_language_id_foreign');
        }
        if (!Schema::connection('mysql')->hasColumn('language_object_group', 'language_object_id')) {
                        $table->integer('language_object_id')->unsigned()->nullable()->index('language_object_group_language_object_id_foreign');
        }
        if (!Schema::connection('mysql')->hasColumn('language_object_group', 'mapped_id')) {
                        $table->integer('mapped_id')->index('language_object_group_mapped_id_foreign');
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
        Schema::connection('mysql')->drop('language_object_group');
    }

}