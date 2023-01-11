<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateSectionSettings extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('section_settings')) {
            Schema::connection('mysql')->create('section_settings', function (Blueprint $table) {
                $table->increments('id');
                $table->bigInteger('section_id')->unsigned()->index('section_settings_section_id_foreign');
                $table->boolean('filter_articles')->default("1");
                $table->string('filter_articles_sort')->default("rating");
                $table->string('filter_articles_sort_direction')->default("desc");
                $table->boolean('filter_sections')->default("1");
                $table->string('filter_sections_sort')->default("rating");
                $table->string('filter_sections_sort_direction')->default("desc");
                $table->boolean('filter_articles_view')->nullable();
                $table->boolean('filter_sections_view')->nullable();
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->integer('articles_limit')->default("10");
                $table->integer('sections_limit')->default("6");
                $table->boolean('show_rating')->default("1");
                $table->boolean('show_article_author')->default("1");
                $table->boolean('hide_section_tags');
                $table->boolean('hide_article_author_inside');
                $table->string('sections_name')->nullable();
                $table->string('articles_name')->nullable();
                $table->boolean('rotate_slides')->default("1");
                $table->boolean('show_background')->default("1");
                $table->string('seo_title')->nullable();
                $table->string('seo_breadcrumbs')->nullable();
                $table->string('seo_description')->nullable();
                $table->boolean('show_opened');
            });
        } else {
            Schema::connection('mysql')->table('section_settings', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('section_settings', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('section_settings', 'section_id')) {
                    $table->bigInteger('section_id')->unsigned()->index('section_settings_section_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('section_settings', 'filter_articles')) {
                    $table->boolean('filter_articles')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('section_settings', 'filter_articles_sort')) {
                    $table->string('filter_articles_sort')->default("rating");
                }
                if (!Schema::connection('mysql')->hasColumn('section_settings', 'filter_articles_sort_direction')) {
                    $table->string('filter_articles_sort_direction')->default("desc");
                }
                if (!Schema::connection('mysql')->hasColumn('section_settings', 'filter_sections')) {
                    $table->boolean('filter_sections')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('section_settings', 'filter_sections_sort')) {
                    $table->string('filter_sections_sort')->default("rating");
                }
                if (!Schema::connection('mysql')->hasColumn('section_settings', 'filter_sections_sort_direction')) {
                    $table->string('filter_sections_sort_direction')->default("desc");
                }
                if (!Schema::connection('mysql')->hasColumn('section_settings', 'filter_articles_view')) {
                    $table->boolean('filter_articles_view')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('section_settings', 'filter_sections_view')) {
                    $table->boolean('filter_sections_view')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('section_settings', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('section_settings', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('section_settings', 'articles_limit')) {
                    $table->integer('articles_limit')->default("10");
                }
                if (!Schema::connection('mysql')->hasColumn('section_settings', 'sections_limit')) {
                    $table->integer('sections_limit')->default("6");
                }
                if (!Schema::connection('mysql')->hasColumn('section_settings', 'show_rating')) {
                    $table->boolean('show_rating')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('section_settings', 'show_article_author')) {
                    $table->boolean('show_article_author')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('section_settings', 'hide_section_tags')) {
                    $table->boolean('hide_section_tags');
                }
                if (!Schema::connection('mysql')->hasColumn('section_settings', 'hide_article_author_inside')) {
                    $table->boolean('hide_article_author_inside');
                }
                if (!Schema::connection('mysql')->hasColumn('section_settings', 'sections_name')) {
                    $table->string('sections_name')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('section_settings', 'articles_name')) {
                    $table->string('articles_name')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('section_settings', 'rotate_slides')) {
                    $table->boolean('rotate_slides')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('section_settings', 'show_background')) {
                    $table->boolean('show_background')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('section_settings', 'seo_title')) {
                    $table->string('seo_title')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('section_settings', 'seo_breadcrumbs')) {
                    $table->string('seo_breadcrumbs')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('section_settings', 'seo_description')) {
                    $table->string('seo_description')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('section_settings', 'show_opened')) {
                    $table->boolean('show_opened');
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
        Schema::connection('mysql')->drop('section_settings');
    }

}