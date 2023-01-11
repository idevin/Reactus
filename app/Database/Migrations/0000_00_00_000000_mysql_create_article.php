<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateArticle extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('article')) {
            Schema::connection('mysql')->create('article', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->dateTime('deleted_at')->nullable();
                $table->string('title');
                $table->boolean('status')->unsigned();
                $table->dateTime('published_at');
                $table->dateTime('unpublished_at')->nullable();
                $table->integer('comments_cnt')->unsigned();
                $table->integer('views_cnt')->unsigned();
                $table->integer('likes_cnt')->unsigned();
                $table->float('rating');
                $table->bigInteger('author_id')->unsigned()->index('article_author_id_foreign');
                $table->bigInteger('section_id')->unsigned()->index('article_section_id_foreign');
                $table->integer('site_id')->unsigned()->index('article_site_id_foreign');
                $table->dateTime('last_comment_at')->nullable();
                $table->integer('last_comment_id')->unsigned()->nullable()->index('article_last_comment_id_foreign');
                $table->string('last_comment_author')->nullable();
                $table->string('settings')->nullable();
                $table->string('image');
                $table->string('slug')->nullable();
                $table->boolean('draft')->default("1");
                $table->boolean('active')->default("1");
                $table->boolean('on_main');
                $table->boolean('on_main_head');
                $table->integer('transfer_to_section')->nullable();
                $table->boolean('transfered');
                $table->string('content_short')->nullable();
                $table->text('content');
                $table->integer('sort_order')->default("1");
                $table->boolean('sort_comments')->default("2");
                $table->text('react_data')->nullable();
                $table->boolean('hide_author');
                $table->boolean('show_article_rating')->default("1");
                $table->string('seo_title')->nullable();
                $table->string('seo_description')->nullable();
                $table->string('seo_h1')->nullable();
                $table->string('seo_breadcrumbs')->nullable();
                $table->boolean('rotate_slides')->default("1");
                $table->boolean('show_background')->default("1");
            });
        } else {
            Schema::connection('mysql')->table('article', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('article', 'id')) {
                    $table->bigIncrements('id');
                }
                if (!Schema::connection('mysql')->hasColumn('article', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('article', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('article', 'deleted_at')) {
                    $table->dateTime('deleted_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('article', 'title')) {
                    $table->string('title');
                }
                if (!Schema::connection('mysql')->hasColumn('article', 'status')) {
                    $table->boolean('status')->unsigned();
                }
                if (!Schema::connection('mysql')->hasColumn('article', 'published_at')) {
                    $table->dateTime('published_at');
                }
                if (!Schema::connection('mysql')->hasColumn('article', 'unpublished_at')) {
                    $table->dateTime('unpublished_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('article', 'comments_cnt')) {
                    $table->integer('comments_cnt')->unsigned();
                }
                if (!Schema::connection('mysql')->hasColumn('article', 'views_cnt')) {
                    $table->integer('views_cnt')->unsigned();
                }
                if (!Schema::connection('mysql')->hasColumn('article', 'likes_cnt')) {
                    $table->integer('likes_cnt')->unsigned();
                }
                if (!Schema::connection('mysql')->hasColumn('article', 'rating')) {
                    $table->float('rating');
                }
                if (!Schema::connection('mysql')->hasColumn('article', 'author_id')) {
                    $table->bigInteger('author_id')->unsigned()->index('article_author_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('article', 'section_id')) {
                    $table->bigInteger('section_id')->unsigned()->index('article_section_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('article', 'site_id')) {
                    $table->integer('site_id')->unsigned()->index('article_site_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('article', 'last_comment_at')) {
                    $table->dateTime('last_comment_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('article', 'last_comment_id')) {
                    $table->integer('last_comment_id')->unsigned()->nullable()->index('article_last_comment_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('article', 'last_comment_author')) {
                    $table->string('last_comment_author')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('article', 'settings')) {
                    $table->string('settings')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('article', 'image')) {
                    $table->string('image');
                }
                if (!Schema::connection('mysql')->hasColumn('article', 'slug')) {
                    $table->string('slug')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('article', 'draft')) {
                    $table->boolean('draft')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('article', 'active')) {
                    $table->boolean('active')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('article', 'on_main')) {
                    $table->boolean('on_main');
                }
                if (!Schema::connection('mysql')->hasColumn('article', 'on_main_head')) {
                    $table->boolean('on_main_head');
                }
                if (!Schema::connection('mysql')->hasColumn('article', 'transfer_to_section')) {
                    $table->integer('transfer_to_section')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('article', 'transfered')) {
                    $table->boolean('transfered');
                }
                if (!Schema::connection('mysql')->hasColumn('article', 'content_short')) {
                    $table->string('content_short')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('article', 'content')) {
                    $table->text('content');
                }
                if (!Schema::connection('mysql')->hasColumn('article', 'sort_order')) {
                    $table->integer('sort_order')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('article', 'sort_comments')) {
                    $table->boolean('sort_comments')->default("2");
                }
                if (!Schema::connection('mysql')->hasColumn('article', 'react_data')) {
                    $table->text('react_data')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('article', 'hide_author')) {
                    $table->boolean('hide_author');
                }
                if (!Schema::connection('mysql')->hasColumn('article', 'show_article_rating')) {
                    $table->boolean('show_article_rating')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('article', 'seo_title')) {
                    $table->string('seo_title')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('article', 'seo_description')) {
                    $table->string('seo_description')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('article', 'seo_h1')) {
                    $table->string('seo_h1')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('article', 'seo_breadcrumbs')) {
                    $table->string('seo_breadcrumbs')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('article', 'rotate_slides')) {
                    $table->boolean('rotate_slides')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('article', 'show_background')) {
                    $table->boolean('show_background')->default("1");
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
        Schema::connection('mysql')->drop('article');
    }

}