<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateObjectFieldValue extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('object_field_value')) {
            Schema::connection('mysql')->create('object_field_value', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('object_field_id')->unsigned()->index('object_field_value_object_field_id_foreign');
                $table->string('value')->nullable();
                $table->string('data_node_id')->nullable()->index('object_field_value_data_node_id_foreign');
            });
        } else {
            Schema::connection('mysql')->table('object_field_value', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('object_field_value', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('object_field_value', 'object_field_id')) {
                    $table->integer('object_field_id')->unsigned()->index('object_field_value_object_field_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('object_field_value', 'value')) {
                    $table->string('value')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('object_field_value', 'data_node_id')) {
                    $table->string('data_node_id')->nullable()->index('object_field_value_data_node_id_foreign');
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
        Schema::connection('mysql')->drop('object_field_value');
    }

}