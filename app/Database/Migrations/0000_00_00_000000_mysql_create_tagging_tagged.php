<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateTaggingTagged extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('tagging_tagged')) {
            Schema::connection('mysql')->create('tagging_tagged', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('taggable_id')->unsigned()->index('tagging_tagged_taggable_id_foreign');
                $table->string('taggable_type');
                $table->string('tag_name');
                $table->string('tag_slug');
            });
        } else {
            Schema::connection('mysql')->table('tagging_tagged', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('tagging_tagged', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('tagging_tagged', 'taggable_id')) {
                    $table->integer('taggable_id')->unsigned()->index('tagging_tagged_taggable_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('tagging_tagged', 'taggable_type')) {
                    $table->string('taggable_type');
                }
                if (!Schema::connection('mysql')->hasColumn('tagging_tagged', 'tag_name')) {
                    $table->string('tag_name');
                }
                if (!Schema::connection('mysql')->hasColumn('tagging_tagged', 'tag_slug')) {
                    $table->string('tag_slug');
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
        Schema::connection('mysql')->drop('tagging_tagged');
    }

}