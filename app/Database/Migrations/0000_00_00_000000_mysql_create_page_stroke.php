<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreatePageStroke extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('page_stroke')) {
            Schema::connection('mysql')->create('page_stroke', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('page_id')->unsigned()->index('page_stroke_page_id_foreign');
                $table->integer('module_stroke_id')->unsigned()->index('page_stroke_module_stroke_id_foreign');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->integer('sort_order');
                $table->integer('position')->default("2");
                $table->boolean('is_active')->default("1");
                $table->dateTime('deleted_at')->nullable();
                $table->string('template_id')->nullable()->index('page_stroke_template_id_foreign');
                $table->json('content_options')->nullable();
            });
        } else {
            Schema::connection('mysql')->table('page_stroke', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('page_stroke', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('page_stroke', 'page_id')) {
                    $table->integer('page_id')->unsigned()->index('page_stroke_page_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('page_stroke', 'module_stroke_id')) {
                    $table->integer('module_stroke_id')->unsigned()->index('page_stroke_module_stroke_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('page_stroke', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('page_stroke', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('page_stroke', 'sort_order')) {
                    $table->integer('sort_order');
                }
                if (!Schema::connection('mysql')->hasColumn('page_stroke', 'position')) {
                    $table->integer('position')->default("2");
                }
                if (!Schema::connection('mysql')->hasColumn('page_stroke', 'is_active')) {
                    $table->boolean('is_active')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('page_stroke', 'deleted_at')) {
                    $table->dateTime('deleted_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('page_stroke', 'template_id')) {
                    $table->string('template_id')->nullable()->index('page_stroke_template_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('page_stroke', 'content_options')) {
                    $table->json('content_options')->nullable();
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
        Schema::connection('mysql')->drop('page_stroke');
    }

}