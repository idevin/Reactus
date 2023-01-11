<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateTaggingTagGroups extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('tagging_tag_groups')) {
            Schema::connection('mysql')->create('tagging_tag_groups', function (Blueprint $table) {
                $table->increments('id');
                $table->string('slug');
                $table->string('name');
            });
        } else {
            Schema::connection('mysql')->table('tagging_tag_groups', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('tagging_tag_groups', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('tagging_tag_groups', 'slug')) {
                    $table->string('slug');
                }
                if (!Schema::connection('mysql')->hasColumn('tagging_tag_groups', 'name')) {
                    $table->string('name');
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
        Schema::connection('mysql')->drop('tagging_tag_groups');
    }

}