<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateSite extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('site')) {
            Schema::connection('mysql')->create('site', function (Blueprint $table) {
                $table->increments('id');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->dateTime('deleted_at')->nullable();
                $table->string('domain');
                $table->string('title');
                $table->text('content')->nullable();
                $table->string('image')->nullable();
                $table->integer('parent_id')->nullable()->index('site_parent_id_foreign');
                $table->integer('lft')->nullable();
                $table->integer('rgt')->nullable();
                $table->integer('depth')->nullable();
                $table->integer('domain_id')->unsigned()->nullable()->index('site_domain_id_foreign');
                $table->integer('rating')->unsigned();
                $table->string('header')->nullable();
                $table->string('header_home')->nullable();
                $table->string('logo')->nullable();
                $table->string('site_header')->nullable();
                $table->string('slogan')->nullable();
                $table->string('favicon')->nullable();
                $table->string('facebook_url')->nullable();
                $table->string('vk_url')->nullable();
                $table->string('twitter_url')->nullable();
                $table->string('ok_url')->nullable();
                $table->string('instagram_url')->nullable();
                $table->string('copyright')->nullable();
                $table->integer('template_id')->index('site_template_id_foreign');
                $table->bigInteger('user_id')->unsigned()->nullable()->index('site_user_id_foreign');
                $table->text('address')->nullable();
                $table->string('work_hours')->nullable();
                $table->string('email')->nullable();
                $table->text('sections_description')->nullable();
                $table->text('articles_description')->nullable();
                $table->boolean('filter_articles')->default("1");
                $table->string('filter_articles_sort')->default("rating");
                $table->string('filter_articles_sort_direction')->default("desc");
                $table->boolean('filter_sections')->default("1");
                $table->string('filter_sections_sort')->default("rating");
                $table->string('filter_sections_sort_direction')->default("desc");
                $table->boolean('filter_articles_view')->nullable();
                $table->boolean('filter_sections_view')->nullable();
                $table->integer('articles_limit')->default("10");
                $table->integer('sections_limit')->default("6");
                $table->text('phone')->nullable();
                $table->integer('template_scheme_id')->unsigned()->nullable()->index('site_template_scheme_id_foreign');
                $table->string('default_color')->nullable();
                $table->boolean('archive');
                $table->boolean('show_article_rating');
                $table->boolean('show_section_rating');
                $table->boolean('hide_article_author_inside');
                $table->boolean('show_article_author');
                $table->boolean('hide_section_tags');
                $table->boolean('breadcrumbs')->default("1");
                $table->boolean('breadcrumbs_position');
                $table->boolean('repeat_animation');
                $table->string('jivosite')->nullable();
                $table->boolean('show_in_pages');
                $table->boolean('show_in_about_page');
                $table->text('text')->nullable();
                $table->integer('feedback_id')->unsigned()->nullable()->index('site_feedback_id_foreign');
                $table->string('coords')->nullable();
                $table->bigInteger('views');
                $table->string('recaptcha')->nullable();
                $table->boolean('hidden');
                $table->json('menu_options')->nullable();
                $table->json('userbar_options')->nullable();
                $table->boolean('disable_indexing');
                $table->text('head_tags')->nullable();
                $table->text('breadcrumbs_options')->nullable();
            });
        } else {
            Schema::connection('mysql')->table('site', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('site', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'deleted_at')) {
                    $table->dateTime('deleted_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'domain')) {
                    $table->string('domain');
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'title')) {
                    $table->string('title');
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'content')) {
                    $table->text('content')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'image')) {
                    $table->string('image')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'parent_id')) {
                    $table->integer('parent_id')->nullable()->index('site_parent_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'lft')) {
                    $table->integer('lft')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'rgt')) {
                    $table->integer('rgt')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'depth')) {
                    $table->integer('depth')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'domain_id')) {
                    $table->integer('domain_id')->unsigned()->nullable()->index('site_domain_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'rating')) {
                    $table->integer('rating')->unsigned();
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'header')) {
                    $table->string('header')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'header_home')) {
                    $table->string('header_home')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'logo')) {
                    $table->string('logo')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'site_header')) {
                    $table->string('site_header')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'slogan')) {
                    $table->string('slogan')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'favicon')) {
                    $table->string('favicon')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'facebook_url')) {
                    $table->string('facebook_url')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'vk_url')) {
                    $table->string('vk_url')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'twitter_url')) {
                    $table->string('twitter_url')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'ok_url')) {
                    $table->string('ok_url')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'instagram_url')) {
                    $table->string('instagram_url')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'copyright')) {
                    $table->string('copyright')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'template_id')) {
                    $table->integer('template_id')->index('site_template_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'user_id')) {
                    $table->bigInteger('user_id')->unsigned()->nullable()->index('site_user_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'address')) {
                    $table->text('address')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'work_hours')) {
                    $table->string('work_hours')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'email')) {
                    $table->string('email')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'sections_description')) {
                    $table->text('sections_description')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'articles_description')) {
                    $table->text('articles_description')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'filter_articles')) {
                    $table->boolean('filter_articles')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'filter_articles_sort')) {
                    $table->string('filter_articles_sort')->default("rating");
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'filter_articles_sort_direction')) {
                    $table->string('filter_articles_sort_direction')->default("desc");
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'filter_sections')) {
                    $table->boolean('filter_sections')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'filter_sections_sort')) {
                    $table->string('filter_sections_sort')->default("rating");
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'filter_sections_sort_direction')) {
                    $table->string('filter_sections_sort_direction')->default("desc");
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'filter_articles_view')) {
                    $table->boolean('filter_articles_view')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'filter_sections_view')) {
                    $table->boolean('filter_sections_view')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'articles_limit')) {
                    $table->integer('articles_limit')->default("10");
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'sections_limit')) {
                    $table->integer('sections_limit')->default("6");
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'phone')) {
                    $table->text('phone')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'template_scheme_id')) {
                    $table->integer('template_scheme_id')->unsigned()->nullable()->index('site_template_scheme_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'default_color')) {
                    $table->string('default_color')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'archive')) {
                    $table->boolean('archive');
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'show_article_rating')) {
                    $table->boolean('show_article_rating');
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'show_section_rating')) {
                    $table->boolean('show_section_rating');
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'hide_article_author_inside')) {
                    $table->boolean('hide_article_author_inside');
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'show_article_author')) {
                    $table->boolean('show_article_author');
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'hide_section_tags')) {
                    $table->boolean('hide_section_tags');
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'breadcrumbs')) {
                    $table->boolean('breadcrumbs')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'breadcrumbs_position')) {
                    $table->boolean('breadcrumbs_position');
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'repeat_animation')) {
                    $table->boolean('repeat_animation');
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'jivosite')) {
                    $table->string('jivosite')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'show_in_pages')) {
                    $table->boolean('show_in_pages');
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'show_in_about_page')) {
                    $table->boolean('show_in_about_page');
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'text')) {
                    $table->text('text')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'feedback_id')) {
                    $table->integer('feedback_id')->unsigned()->nullable()->index('site_feedback_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'coords')) {
                    $table->string('coords')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'views')) {
                    $table->bigInteger('views');
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'recaptcha')) {
                    $table->string('recaptcha')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'hidden')) {
                    $table->boolean('hidden');
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'menu_options')) {
                    $table->json('menu_options')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'userbar_options')) {
                    $table->json('userbar_options')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'disable_indexing')) {
                    $table->boolean('disable_indexing');
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'head_tags')) {
                    $table->text('head_tags')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('site', 'breadcrumbs_options')) {
                    $table->text('breadcrumbs_options')->nullable();
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
        Schema::connection('mysql')->drop('site');
    }

}