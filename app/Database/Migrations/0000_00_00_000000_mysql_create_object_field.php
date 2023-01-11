<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateObjectField extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('object_field')) {
            Schema::connection('mysql')->create('object_field', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('field_type');
                $table->string('default_value')->nullable();
                $table->string('alias');
                $table->boolean('required');
                $table->integer('object_field_group_id')->unsigned()->index('object_field_object_field_group_id_foreign');
                $table->boolean('use_in_filter');
                $table->boolean('use_in_catalog_list');
            });
        } else {
            Schema::connection('mysql')->table('object_field', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('object_field', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('object_field', 'name')) {
                    $table->string('name');
                }
                if (!Schema::connection('mysql')->hasColumn('object_field', 'field_type')) {
                    $table->string('field_type');
                }
                if (!Schema::connection('mysql')->hasColumn('object_field', 'default_value')) {
                    $table->string('default_value')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('object_field', 'alias')) {
                    $table->string('alias');
                }
                if (!Schema::connection('mysql')->hasColumn('object_field', 'required')) {
                    $table->boolean('required');
                }
                if (!Schema::connection('mysql')->hasColumn('object_field', 'object_field_group_id')) {
                    $table->integer('object_field_group_id')->unsigned()->index('object_field_object_field_group_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('object_field', 'use_in_filter')) {
                    $table->boolean('use_in_filter');
                }
                if (!Schema::connection('mysql')->hasColumn('object_field', 'use_in_catalog_list')) {
                    $table->boolean('use_in_catalog_list');
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
        Schema::connection('mysql')->drop('object_field');
    }

}