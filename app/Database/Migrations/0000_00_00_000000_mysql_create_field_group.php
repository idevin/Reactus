<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateFieldGroup extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('field_group')) {
            Schema::connection('mysql')->create('field_group', function (Blueprint $table) {
                $table->increments('id');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->string('name');
                $table->boolean('multi_field');
                $table->integer('parent_id')->nullable();
                $table->integer('lft')->nullable();
                $table->integer('rgt')->nullable();
                $table->integer('depth')->nullable();
                $table->boolean('for_module');
            });
        } else {
            Schema::connection('mysql')->table('field_group', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('field_group', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('field_group', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('field_group', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('field_group', 'name')) {
                    $table->string('name');
                }
                if (!Schema::connection('mysql')->hasColumn('field_group', 'multi_field')) {
                    $table->boolean('multi_field');
                }
                if (!Schema::connection('mysql')->hasColumn('field_group', 'parent_id')) {
                    $table->integer('parent_id')->nullable()->index('field_group_parent_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('field_group', 'lft')) {
                    $table->integer('lft')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('field_group', 'rgt')) {
                    $table->integer('rgt')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('field_group', 'depth')) {
                    $table->integer('depth')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('field_group', 'for_module')) {
                    $table->boolean('for_module');
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
        Schema::connection('mysql')->drop('field_group');
    }

}