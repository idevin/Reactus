<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateModuleArticle extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('module_article')) {
            Schema::connection('mysql')->create('module_article', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('site_id')->unsigned()->index('module_article_site_id_foreign');
                $table->boolean('sort_by')->default("1");
                $table->boolean('view')->default("1");
                $table->boolean('sort_order')->default("1");
                $table->boolean('block_type')->default("1");
                $table->string('name')->nullable();
                $table->integer('module_id')->unsigned()->nullable()->index('module_article_module_id_foreign');
                $table->bigInteger('section_id')->unsigned()->nullable()->index('module_article_section_id_foreign');
                $table->boolean('block_view');
            });
        } else {
            Schema::connection('mysql')->table('module_article', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('module_article', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('module_article', 'site_id')) {
                    $table->integer('site_id')->unsigned()->index('module_article_site_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('module_article', 'sort_by')) {
                    $table->boolean('sort_by')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('module_article', 'view')) {
                    $table->boolean('view')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('module_article', 'sort_order')) {
                    $table->boolean('sort_order')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('module_article', 'block_type')) {
                    $table->boolean('block_type')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('module_article', 'name')) {
                    $table->string('name')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('module_article', 'module_id')) {
                    $table->integer('module_id')->unsigned()->nullable()->index('module_article_module_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('module_article', 'section_id')) {
                    $table->bigInteger('section_id')->unsigned()->nullable()->index('module_article_section_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('module_article', 'block_view')) {
                    $table->boolean('block_view');
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
        Schema::connection('mysql')->drop('module_article');
    }

}