<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreatePageStrokeModule extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('page_stroke_module')) {
            Schema::connection('mysql')->create('page_stroke_module', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('page_stroke_id')->unsigned()->index('page_stroke_module_page_stroke_id_foreign');
                $table->string('module_class');
                $table->integer('module_id')->unsigned()->nullable()->index('page_stroke_module_module_id_foreign');
                $table->integer('sort_order');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->boolean('is_active')->default("1");
                $table->dateTime('deleted_at')->nullable();
                $table->string('template_id')->nullable()->index('page_stroke_module_template_id_foreign');
                $table->json('content_options')->nullable();
            });
        } else {
            Schema::connection('mysql')->table('page_stroke_module', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('page_stroke_module', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('page_stroke_module', 'page_stroke_id')) {
                    $table->integer('page_stroke_id')->unsigned()->index('page_stroke_module_page_stroke_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('page_stroke_module', 'module_class')) {
                    $table->string('module_class');
                }
                if (!Schema::connection('mysql')->hasColumn('page_stroke_module', 'module_id')) {
                    $table->integer('module_id')->unsigned()->nullable()->index('page_stroke_module_module_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('page_stroke_module', 'sort_order')) {
                    $table->integer('sort_order');
                }
                if (!Schema::connection('mysql')->hasColumn('page_stroke_module', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('page_stroke_module', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('page_stroke_module', 'is_active')) {
                    $table->boolean('is_active')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('page_stroke_module', 'deleted_at')) {
                    $table->dateTime('deleted_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('page_stroke_module', 'template_id')) {
                    $table->string('template_id')->nullable()->index('page_stroke_module_template_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('page_stroke_module', 'content_options')) {
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
        Schema::connection('mysql')->drop('page_stroke_module');
    }

}