<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreatePageStrokeModuleRevision extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('page_stroke_module_revision')) {
            Schema::connection('mysql')->create('page_stroke_module_revision', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('page_stroke_id')->unsigned()->index('page_stroke_module_revision_page_stroke_id_foreign');
                $table->string('module_class');
                $table->integer('module_id')->unsigned()->nullable()->index('page_stroke_module_revision_module_id_foreign');
                $table->integer('sort_order');
                $table->boolean('is_active')->default("1");
                $table->boolean('is_current')->nullable();
                $table->dateTime('deleted_at')->nullable();
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->string('template_id')->nullable()->index('page_stroke_module_revision_template_id_foreign');
                $table->json('content_options')->nullable();
            });
        } else {
            Schema::connection('mysql')->table('page_stroke_module_revision', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('page_stroke_module_revision', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('page_stroke_module_revision', 'page_stroke_id')) {
                    $table->integer('page_stroke_id')->unsigned()->index('page_stroke_module_revision_page_stroke_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('page_stroke_module_revision', 'module_class')) {
                    $table->string('module_class');
                }
                if (!Schema::connection('mysql')->hasColumn('page_stroke_module_revision', 'module_id')) {
                    $table->integer('module_id')->unsigned()->nullable()->index('page_stroke_module_revision_module_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('page_stroke_module_revision', 'sort_order')) {
                    $table->integer('sort_order');
                }
                if (!Schema::connection('mysql')->hasColumn('page_stroke_module_revision', 'is_active')) {
                    $table->boolean('is_active')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('page_stroke_module_revision', 'is_current')) {
                    $table->boolean('is_current')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('page_stroke_module_revision', 'deleted_at')) {
                    $table->dateTime('deleted_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('page_stroke_module_revision', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('page_stroke_module_revision', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('page_stroke_module_revision', 'template_id')) {
                    $table->string('template_id')->nullable()->index('page_stroke_module_revision_template_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('page_stroke_module_revision', 'content_options')) {
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
        Schema::connection('mysql')->drop('page_stroke_module_revision');
    }

}