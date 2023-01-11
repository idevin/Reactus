<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateBlogSection extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('blog_section')) {
            Schema::connection('mysql')->create('blog_section', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('user_id')->unsigned()->nullable()->index('blog_section_user_id_foreign');
                $table->integer('site_id')->unsigned()->index('blog_section_site_id_foreign');
                $table->text('content')->nullable();
                $table->text('react_data')->nullable();
                $table->string('title');
                $table->string('image')->nullable();
                $table->string('slug');
                $table->string('path');
                $table->string('content_short')->nullable();
                $table->integer('rating')->unsigned();
                $table->integer('articles_cnt')->unsigned();
                $table->integer('views_cnt')->unsigned();
                $table->bigInteger('last_comment_id')->unsigned()->nullable()->index('blog_section_last_comment_id_foreign');
                $table->bigInteger('last_article_id')->unsigned()->nullable()->index('blog_section_last_article_id_foreign');
                $table->integer('comments_cnt')->unsigned();
                $table->boolean('is_secret');
                $table->boolean('sort_order')->default("1");
                $table->bigInteger('parent_id')->nullable()->index('blog_section_parent_id_foreign');
                $table->integer('lft')->nullable();
                $table->integer('rgt')->nullable();
                $table->integer('depth')->nullable();
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->dateTime('deleted_at')->nullable();
                $table->string('catalog_sort_by')->nullable();
                $table->string('catalog_sort_order')->nullable();
                $table->string('catalog_title')->nullable();
                $table->integer('object_id')->unsigned()->nullable()->index('blog_section_object_id_foreign');
                $table->text('sort_options')->nullable();
                $table->text('filter_settings')->nullable();
                $table->string('settings')->nullable();
                $table->string('seo_description')->nullable();
                $table->string('seo_breadcrumbs')->nullable();
                $table->string('seo_h1')->nullable();
                $table->string('seo_title')->nullable();
                $table->boolean('transfered');
                $table->integer('transfer_to_section')->unsigned()->nullable();
                $table->dateTime('last_comment_date')->nullable();
                $table->dateTime('last_article_date')->nullable();
                $table->integer('members_cnt');
            });
        } else {
            Schema::connection('mysql')->table('blog_section', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('blog_section', 'id')) {
                    $table->bigIncrements('id');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_section', 'user_id')) {
                    $table->bigInteger('user_id')->unsigned()->nullable()->index('blog_section_user_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_section', 'site_id')) {
                    $table->integer('site_id')->unsigned()->index('blog_section_site_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_section', 'content')) {
                    $table->text('content')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_section', 'react_data')) {
                    $table->text('react_data')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_section', 'title')) {
                    $table->string('title');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_section', 'image')) {
                    $table->string('image')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_section', 'slug')) {
                    $table->string('slug');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_section', 'path')) {
                    $table->string('path');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_section', 'content_short')) {
                    $table->string('content_short')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_section', 'rating')) {
                    $table->integer('rating')->unsigned();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_section', 'articles_cnt')) {
                    $table->integer('articles_cnt')->unsigned();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_section', 'views_cnt')) {
                    $table->integer('views_cnt')->unsigned();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_section', 'last_comment_id')) {
                    $table->bigInteger('last_comment_id')->unsigned()->nullable()->index('blog_section_last_comment_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_section', 'last_article_id')) {
                    $table->bigInteger('last_article_id')->unsigned()->nullable()->index('blog_section_last_article_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_section', 'comments_cnt')) {
                    $table->integer('comments_cnt')->unsigned();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_section', 'is_secret')) {
                    $table->boolean('is_secret');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_section', 'sort_order')) {
                    $table->boolean('sort_order')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('blog_section', 'parent_id')) {
                    $table->bigInteger('parent_id')->nullable()->index('blog_section_parent_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_section', 'lft')) {
                    $table->integer('lft')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_section', 'rgt')) {
                    $table->integer('rgt')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_section', 'depth')) {
                    $table->integer('depth')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_section', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_section', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_section', 'deleted_at')) {
                    $table->dateTime('deleted_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_section', 'catalog_sort_by')) {
                    $table->string('catalog_sort_by')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_section', 'catalog_sort_order')) {
                    $table->string('catalog_sort_order')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_section', 'catalog_title')) {
                    $table->string('catalog_title')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_section', 'object_id')) {
                    $table->integer('object_id')->unsigned()->nullable()->index('blog_section_object_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_section', 'sort_options')) {
                    $table->text('sort_options')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_section', 'filter_settings')) {
                    $table->text('filter_settings')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_section', 'settings')) {
                    $table->string('settings')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_section', 'seo_description')) {
                    $table->string('seo_description')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_section', 'seo_breadcrumbs')) {
                    $table->string('seo_breadcrumbs')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_section', 'seo_h1')) {
                    $table->string('seo_h1')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_section', 'seo_title')) {
                    $table->string('seo_title')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_section', 'transfered')) {
                    $table->boolean('transfered');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_section', 'transfer_to_section')) {
                    $table->integer('transfer_to_section')->unsigned()->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_section', 'last_comment_date')) {
                    $table->dateTime('last_comment_date')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_section', 'last_article_date')) {
                    $table->dateTime('last_article_date')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_section', 'members_cnt')) {
                    $table->integer('members_cnt');
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
        Schema::connection('mysql')->drop('blog_section');
    }

}