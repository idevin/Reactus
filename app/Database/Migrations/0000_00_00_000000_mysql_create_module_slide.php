<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateModuleSlide extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('module_slide')) {
            Schema::connection('mysql')->create('module_slide', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('module_slider_id')->unsigned()->index('module_slide_module_slider_id_foreign');
                $table->text('roles')->nullable();
                $table->boolean('sort_order')->default("1");
                $table->text('url')->nullable();
                $table->string('title')->nullable();
                $table->string('name')->nullable();
                $table->string('short_description')->nullable();
                $table->boolean('slider_type')->default("1");
                $table->boolean('content_type')->default("1");
                $table->boolean('sort_by')->nullable();
                $table->integer('slides_count')->default("1");
                $table->boolean('period')->nullable();
                $table->dateTime('period_start')->nullable();
                $table->dateTime('period_end')->nullable();
                $table->boolean('publish')->default("1");
                $table->dateTime('publish_start')->nullable();
                $table->dateTime('publish_end')->nullable();
                $table->text('action_level')->nullable();
                $table->bigInteger('section_id')->unsigned()->nullable()->index('module_slide_section_id_foreign');
                $table->bigInteger('article_id')->unsigned()->nullable()->index('module_slide_article_id_foreign');
                $table->integer('image_id')->nullable()->index('module_slide_image_id_foreign');
            });
        } else {
            Schema::connection('mysql')->table('module_slide', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('module_slide', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('module_slide', 'module_slider_id')) {
                    $table->integer('module_slider_id')->unsigned()->index('module_slide_module_slider_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('module_slide', 'roles')) {
                    $table->text('roles')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('module_slide', 'sort_order')) {
                    $table->boolean('sort_order')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('module_slide', 'url')) {
                    $table->text('url')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('module_slide', 'title')) {
                    $table->string('title')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('module_slide', 'name')) {
                    $table->string('name')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('module_slide', 'short_description')) {
                    $table->string('short_description')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('module_slide', 'slider_type')) {
                    $table->boolean('slider_type')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('module_slide', 'content_type')) {
                    $table->boolean('content_type')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('module_slide', 'sort_by')) {
                    $table->boolean('sort_by')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('module_slide', 'slides_count')) {
                    $table->integer('slides_count')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('module_slide', 'period')) {
                    $table->boolean('period')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('module_slide', 'period_start')) {
                    $table->dateTime('period_start')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('module_slide', 'period_end')) {
                    $table->dateTime('period_end')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('module_slide', 'publish')) {
                    $table->boolean('publish')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('module_slide', 'publish_start')) {
                    $table->dateTime('publish_start')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('module_slide', 'publish_end')) {
                    $table->dateTime('publish_end')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('module_slide', 'action_level')) {
                    $table->text('action_level')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('module_slide', 'section_id')) {
                    $table->bigInteger('section_id')->unsigned()->nullable()->index('module_slide_section_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('module_slide', 'article_id')) {
                    $table->bigInteger('article_id')->unsigned()->nullable()->index('module_slide_article_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('module_slide', 'image_id')) {
                    $table->integer('image_id')->nullable()->index('module_slide_image_id_foreign');
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
        Schema::connection('mysql')->drop('module_slide');
    }

}