<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateField extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('field')) {
            Schema::connection('mysql')->create('field', function (Blueprint $table) {
                $table->increments('id');
                $table->boolean('field_type');
                $table->string('placeholder')->nullable();
                $table->string('alias');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->dateTime('deleted_at')->nullable();
                $table->integer('site_id')->unsigned()->nullable()->index('field_site_id_foreign');
                $table->string('name')->nullable();
                $table->integer('field_group_id')->unsigned()->index('field_field_group_id_foreign');
                $table->boolean('required');
                $table->integer('sort_order')->nullable();
            });
        } else {
            Schema::connection('mysql')->table('field', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('field', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('field', 'field_type')) {
                    $table->boolean('field_type');
                }
                if (!Schema::connection('mysql')->hasColumn('field', 'placeholder')) {
                    $table->string('placeholder')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('field', 'alias')) {
                    $table->string('alias');
                }
                if (!Schema::connection('mysql')->hasColumn('field', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('field', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('field', 'deleted_at')) {
                    $table->dateTime('deleted_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('field', 'site_id')) {
                    $table->integer('site_id')->unsigned()->nullable()->index('field_site_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('field', 'name')) {
                    $table->string('name')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('field', 'field_group_id')) {
                    $table->integer('field_group_id')->unsigned()->index('field_field_group_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('field', 'required')) {
                    $table->boolean('required');
                }
                if (!Schema::connection('mysql')->hasColumn('field', 'sort_order')) {
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
        Schema::connection('mysql')->drop('field');
    }

}