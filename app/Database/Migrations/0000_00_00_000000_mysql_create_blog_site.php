<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateBlogSite extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('blog_site')) {
            Schema::connection('mysql')->create('blog_site', function (Blueprint $table) {
                $table->increments('id');
                $table->string('domain');
                $table->string('sections_description')->nullable();
                $table->string('articles_description')->nullable();
                $table->string('filter_articles_sort')->default("rating");
                $table->string('filter_articles_sort_direction')->default("desc");
                $table->string('filter_sections')->default("1");
                $table->string('filter_sections_sort')->default("rating");
                $table->string('filter_sections_sort_direction')->default("desc");
                $table->boolean('filter_articles_view');
                $table->boolean('filter_sections_view');
                $table->integer('articles_limit')->default("10");
                $table->integer('sections_limit')->default("6");
                $table->boolean('show_article_rating');
                $table->boolean('show_section_rating');
                $table->boolean('hide_section_tabs');
                $table->string('breadcrumbs')->default("1");
                $table->boolean('breadcrumbs_position');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->string('title');
                $table->text('content');
                $table->integer('domain_id')->unsigned()->nullable()->index('blog_site_domain_id_foreign');
                $table->bigInteger('views');
                $table->integer('domain_volume_id')->unsigned()->nullable()->index('blog_site_domain_volume_id_foreign');
                $table->bigInteger('user_id')->unsigned()->nullable()->index('blog_site_user_id_foreign');
            });
        } else {
            Schema::connection('mysql')->table('blog_site', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('blog_site', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_site', 'domain')) {
                    $table->string('domain');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_site', 'sections_description')) {
                    $table->string('sections_description')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_site', 'articles_description')) {
                    $table->string('articles_description')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_site', 'filter_articles_sort')) {
                    $table->string('filter_articles_sort')->default("rating");
                }
                if (!Schema::connection('mysql')->hasColumn('blog_site', 'filter_articles_sort_direction')) {
                    $table->string('filter_articles_sort_direction')->default("desc");
                }
                if (!Schema::connection('mysql')->hasColumn('blog_site', 'filter_sections')) {
                    $table->string('filter_sections')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('blog_site', 'filter_sections_sort')) {
                    $table->string('filter_sections_sort')->default("rating");
                }
                if (!Schema::connection('mysql')->hasColumn('blog_site', 'filter_sections_sort_direction')) {
                    $table->string('filter_sections_sort_direction')->default("desc");
                }
                if (!Schema::connection('mysql')->hasColumn('blog_site', 'filter_articles_view')) {
                    $table->boolean('filter_articles_view');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_site', 'filter_sections_view')) {
                    $table->boolean('filter_sections_view');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_site', 'articles_limit')) {
                    $table->integer('articles_limit')->default("10");
                }
                if (!Schema::connection('mysql')->hasColumn('blog_site', 'sections_limit')) {
                    $table->integer('sections_limit')->default("6");
                }
                if (!Schema::connection('mysql')->hasColumn('blog_site', 'show_article_rating')) {
                    $table->boolean('show_article_rating');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_site', 'show_section_rating')) {
                    $table->boolean('show_section_rating');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_site', 'hide_section_tabs')) {
                    $table->boolean('hide_section_tabs');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_site', 'breadcrumbs')) {
                    $table->string('breadcrumbs')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('blog_site', 'breadcrumbs_position')) {
                    $table->boolean('breadcrumbs_position');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_site', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_site', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_site', 'title')) {
                    $table->string('title');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_site', 'content')) {
                    $table->text('content');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_site', 'domain_id')) {
                    $table->integer('domain_id')->unsigned()->nullable()->index('blog_site_domain_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_site', 'views')) {
                    $table->bigInteger('views');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_site', 'domain_volume_id')) {
                    $table->integer('domain_volume_id')->unsigned()->nullable()->index('blog_site_domain_volume_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_site', 'user_id')) {
                    $table->bigInteger('user_id')->unsigned()->nullable()->index('blog_site_user_id_foreign');
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
        Schema::connection('mysql')->drop('blog_site');
    }

}