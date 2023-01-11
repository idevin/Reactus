<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateFieldUserValue extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('field_user_value')) {
            Schema::connection('mysql')->create('field_user_value', function (Blueprint $table) {
                $table->increments('id');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->bigInteger('user_id')->unsigned()->index('field_user_value_user_id_foreign');
                $table->integer('field_user_group_id')->unsigned()->index('field_user_value_field_user_group_id_foreign');
                $table->integer('site_id')->unsigned()->index('field_user_value_site_id_foreign');
                $table->string('value')->nullable();
                $table->string('visibility')->nullable();
                $table->integer('field_id')->unsigned()->index('field_user_value_field_id_foreign');
            });
        } else {
            Schema::connection('mysql')->table('field_user_value', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('field_user_value', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('field_user_value', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('field_user_value', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('field_user_value', 'user_id')) {
                    $table->bigInteger('user_id')->unsigned()->index('field_user_value_user_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('field_user_value', 'field_user_group_id')) {
                    $table->integer('field_user_group_id')->unsigned()->index('field_user_value_field_user_group_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('field_user_value', 'site_id')) {
                    $table->integer('site_id')->unsigned()->index('field_user_value_site_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('field_user_value', 'value')) {
                    $table->string('value')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('field_user_value', 'visibility')) {
                    $table->string('visibility')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('field_user_value', 'field_id')) {
                    $table->integer('field_id')->unsigned()->index('field_user_value_field_id_foreign');
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
        Schema::connection('mysql')->drop('field_user_value');
    }

}