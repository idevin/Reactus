<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateBlogArticle extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('blog_article')) {
            Schema::connection('mysql')->create('blog_article', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('title');
                $table->text('content');
                $table->text('react_data');
                $table->string('content_short');
                $table->boolean('status')->unsigned();
                $table->boolean('active')->default("1");
                $table->boolean('draft');
                $table->boolean('sort_order');
                $table->boolean('sort_comments')->nullable();
                $table->integer('comments_cnt')->unsigned();
                $table->integer('views_cnt')->unsigned();
                $table->integer('likes_cnt')->unsigned();
                $table->float('rating')->unsigned();
                $table->bigInteger('last_comment_id')->unsigned()->nullable()->index('blog_article_last_comment_id_foreign');
                $table->bigInteger('author_id')->unsigned()->index('blog_article_author_id_foreign');
                $table->bigInteger('section_id')->unsigned()->index('blog_article_section_id_foreign');
                $table->integer('site_id')->unsigned()->index('blog_article_site_id_foreign');
                $table->string('last_comment_author')->nullable();
                $table->dateTime('published_at')->nullable();
                $table->dateTime('unpublished_at')->nullable();
                $table->dateTime('last_comment_at')->nullable();
                $table->string('settings')->nullable();
                $table->string('image')->nullable();
                $table->string('slug');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->dateTime('deleted_at')->nullable();
                $table->boolean('rotate_slides')->default("1");
                $table->boolean('show_background')->default("1");
                $table->boolean('on_main');
                $table->boolean('on_main_head');
                $table->boolean('show_article_rating')->default("1");
                $table->string('seo_title')->nullable();
                $table->string('seo_description')->nullable();
                $table->string('seo_breadcrumbs')->nullable();
                $table->string('seo_h1')->nullable();
                $table->boolean('hide_author');
            });
        } else {
            Schema::connection('mysql')->table('blog_article', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('blog_article', 'id')) {
                    $table->bigIncrements('id');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_article', 'title')) {
                    $table->string('title');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_article', 'content')) {
                    $table->text('content');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_article', 'react_data')) {
                    $table->text('react_data');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_article', 'content_short')) {
                    $table->string('content_short');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_article', 'status')) {
                    $table->boolean('status')->unsigned();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_article', 'active')) {
                    $table->boolean('active')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('blog_article', 'draft')) {
                    $table->boolean('draft');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_article', 'sort_order')) {
                    $table->boolean('sort_order');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_article', 'sort_comments')) {
                    $table->boolean('sort_comments')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_article', 'comments_cnt')) {
                    $table->integer('comments_cnt')->unsigned();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_article', 'views_cnt')) {
                    $table->integer('views_cnt')->unsigned();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_article', 'likes_cnt')) {
                    $table->integer('likes_cnt')->unsigned();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_article', 'rating')) {
                    $table->float('rating')->unsigned();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_article', 'last_comment_id')) {
                    $table->bigInteger('last_comment_id')->unsigned()->nullable()->index('blog_article_last_comment_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_article', 'author_id')) {
                    $table->bigInteger('author_id')->unsigned()->index('blog_article_author_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_article', 'section_id')) {
                    $table->bigInteger('section_id')->unsigned()->index('blog_article_section_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_article', 'site_id')) {
                    $table->integer('site_id')->unsigned()->index('blog_article_site_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_article', 'last_comment_author')) {
                    $table->string('last_comment_author')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_article', 'published_at')) {
                    $table->dateTime('published_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_article', 'unpublished_at')) {
                    $table->dateTime('unpublished_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_article', 'last_comment_at')) {
                    $table->dateTime('last_comment_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_article', 'settings')) {
                    $table->string('settings')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_article', 'image')) {
                    $table->string('image')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_article', 'slug')) {
                    $table->string('slug');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_article', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_article', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_article', 'deleted_at')) {
                    $table->dateTime('deleted_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_article', 'rotate_slides')) {
                    $table->boolean('rotate_slides')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('blog_article', 'show_background')) {
                    $table->boolean('show_background')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('blog_article', 'on_main')) {
                    $table->boolean('on_main');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_article', 'on_main_head')) {
                    $table->boolean('on_main_head');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_article', 'show_article_rating')) {
                    $table->boolean('show_article_rating')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('blog_article', 'seo_title')) {
                    $table->string('seo_title')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_article', 'seo_description')) {
                    $table->string('seo_description')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_article', 'seo_breadcrumbs')) {
                    $table->string('seo_breadcrumbs')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_article', 'seo_h1')) {
                    $table->string('seo_h1')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_article', 'hide_author')) {
                    $table->boolean('hide_author');
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
        Schema::connection('mysql')->drop('blog_article');
    }

}