<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateTaggingTags extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('tagging_tags')) {
            Schema::connection('mysql')->create('tagging_tags', function (Blueprint $table) {
                $table->increments('id');
                $table->string('slug');
                $table->string('name');
                $table->boolean('suggest');
                $table->integer('count')->unsigned();
                $table->boolean('disabled');
            });
        } else {
            Schema::connection('mysql')->table('tagging_tags', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('tagging_tags', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('tagging_tags', 'slug')) {
                    $table->string('slug');
                }
                if (!Schema::connection('mysql')->hasColumn('tagging_tags', 'name')) {
                    $table->string('name');
                }
                if (!Schema::connection('mysql')->hasColumn('tagging_tags', 'suggest')) {
                    $table->boolean('suggest');
                }
                if (!Schema::connection('mysql')->hasColumn('tagging_tags', 'count')) {
                    $table->integer('count')->unsigned();
                }
                if (!Schema::connection('mysql')->hasColumn('tagging_tags', 'disabled')) {
                    $table->boolean('disabled');
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
        Schema::connection('mysql')->drop('tagging_tags');
    }

}