<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateFieldUserGroup extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('field_user_group')) {
            Schema::connection('mysql')->create('field_user_group', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('field_group_id')->unsigned()->index('field_user_group_field_group_id_foreign');
                $table->bigInteger('user_id')->unsigned()->index('field_user_group_user_id_foreign');
                $table->boolean('visibility')->default("1");
                $table->boolean('on_homepage');
            });
        } else {
            Schema::connection('mysql')->table('field_user_group', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('field_user_group', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('field_user_group', 'field_group_id')) {
                    $table->integer('field_group_id')->unsigned()->index('field_user_group_field_group_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('field_user_group', 'user_id')) {
                    $table->bigInteger('user_id')->unsigned()->index('field_user_group_user_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('field_user_group', 'visibility')) {
                    $table->boolean('visibility')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('field_user_group', 'on_homepage')) {
                    $table->boolean('on_homepage');
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
        Schema::connection('mysql')->drop('field_user_group');
    }

}