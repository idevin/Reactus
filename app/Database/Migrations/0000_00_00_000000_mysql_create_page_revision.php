<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreatePageRevision extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('page_revision')) {
            Schema::connection('mysql')->create('page_revision', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('page_id')->unsigned()->index('page_revision_page_id_foreign');
                $table->boolean('action');
                $table->string('name');
                $table->boolean('is_current');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->dateTime('deleted_at')->nullable();
                $table->json('params');
            });
        } else {
            Schema::connection('mysql')->table('page_revision', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('page_revision', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('page_revision', 'page_id')) {
                    $table->integer('page_id')->unsigned()->index('page_revision_page_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('page_revision', 'action')) {
                    $table->boolean('action');
                }
                if (!Schema::connection('mysql')->hasColumn('page_revision', 'name')) {
                    $table->string('name');
                }
                if (!Schema::connection('mysql')->hasColumn('page_revision', 'is_current')) {
                    $table->boolean('is_current');
                }
                if (!Schema::connection('mysql')->hasColumn('page_revision', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('page_revision', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('page_revision', 'deleted_at')) {
                    $table->dateTime('deleted_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('page_revision', 'params')) {
                    $table->json('params');
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
        Schema::connection('mysql')->drop('page_revision');
    }

}