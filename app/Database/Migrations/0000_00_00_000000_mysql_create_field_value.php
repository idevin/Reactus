<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateFieldValue extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('field_value')) {
            Schema::connection('mysql')->create('field_value', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('field_id')->unsigned()->index('field_value_field_id_foreign');
                $table->string('value');
                $table->integer('sort_order')->nullable();
            });
        } else {
            Schema::connection('mysql')->table('field_value', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('field_value', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('field_value', 'field_id')) {
                    $table->integer('field_id')->unsigned()->index('field_value_field_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('field_value', 'value')) {
                    $table->string('value');
                }
                if (!Schema::connection('mysql')->hasColumn('field_value', 'sort_order')) {
                    $table->integer('sort_order')->nullable();
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
        Schema::connection('mysql')->drop('field_value');
    }

}