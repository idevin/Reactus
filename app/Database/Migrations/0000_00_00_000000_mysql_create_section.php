<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateSection extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('section')) {
            Schema::connection('mysql')->create('section', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->integer('site_id')->unsigned()->index('section_site_id_foreign');
                $table->string('title');
                $table->string('image')->nullable();
                $table->string('slug');
                $table->float('rating');
                $table->integer('articles_cnt')->unsigned();
                $table->boolean('is_private');
                $table->boolean('is_community');
                $table->boolean('is_secret');
                $table->integer('members_cnt')->unsigned();
                $table->bigInteger('parent_id')->nullable()->index('section_parent_id_foreign');
                $table->integer('lft')->nullable();
                $table->integer('rgt')->nullable();
                $table->integer('depth')->nullable();
                $table->bigInteger('views_cnt')->unsigned();
                $table->bigInteger('last_comment_id')->unsigned()->nullable()->index('section_last_comment_id_foreign');
                $table->dateTime('last_article_date')->nullable();
                $table->dateTime('last_comment_date')->nullable();
                $table->bigInteger('comments_cnt');
                $table->dateTime('deleted_at')->nullable();
                $table->integer('sort_order')->default("1");
                $table->integer('transfer_to_section')->nullable();
                $table->boolean('transfered');
                $table->string('content_short')->nullable();
                $table->text('content')->nullable();
                $table->bigInteger('user_id')->unsigned()->nullable()->index('section_user_id_foreign');
                $table->text('react_data')->nullable();
                $table->string('settings')->nullable();
                $table->string('seo_title')->nullable();
                $table->string('seo_description')->nullable();
                $table->string('seo_h1')->nullable();
                $table->string('seo_breadcrumbs')->nullable();
                $table->text('filter_settings')->nullable();
                $table->text('sort_options')->nullable();
                $table->integer('object_id')->nullable()->index('section_object_id_foreign');
                $table->string('catalog_title')->nullable();
                $table->string('catalog_sort_by')->nullable();
                $table->boolean('catalog_sort_order')->nullable();
            });
        } else {
            Schema::connection('mysql')->table('section', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('section', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('section', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('section', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('section', 'site_id')) {
                    $table->integer('site_id')->unsigned()->index('section_site_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('section', 'title')) {
                    $table->string('title');
                }
                if (!Schema::connection('mysql')->hasColumn('section', 'image')) {
                    $table->string('image')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('section', 'slug')) {
                    $table->string('slug');
                }
                if (!Schema::connection('mysql')->hasColumn('section', 'rating')) {
                    $table->float('rating');
                }
                if (!Schema::connection('mysql')->hasColumn('section', 'articles_cnt')) {
                    $table->integer('articles_cnt')->unsigned();
                }
                if (!Schema::connection('mysql')->hasColumn('section', 'is_private')) {
                    $table->boolean('is_private');
                }
                if (!Schema::connection('mysql')->hasColumn('section', 'is_community')) {
                    $table->boolean('is_community');
                }
                if (!Schema::connection('mysql')->hasColumn('section', 'is_secret')) {
                    $table->boolean('is_secret');
                }
                if (!Schema::connection('mysql')->hasColumn('section', 'members_cnt')) {
                    $table->integer('members_cnt')->unsigned();
                }
                if (!Schema::connection('mysql')->hasColumn('section', 'parent_id')) {
                    $table->bigInteger('parent_id')->nullable()->index('section_parent_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('section', 'lft')) {
                    $table->integer('lft')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('section', 'rgt')) {
                    $table->integer('rgt')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('section', 'depth')) {
                    $table->integer('depth')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('section', 'views_cnt')) {
                    $table->bigInteger('views_cnt')->unsigned();
                }
                if (!Schema::connection('mysql')->hasColumn('section', 'last_comment_id')) {
                    $table->bigInteger('last_comment_id')->unsigned()->nullable()->index('section_last_comment_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('section', 'last_article_date')) {
                    $table->dateTime('last_article_date')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('section', 'last_comment_date')) {
                    $table->dateTime('last_comment_date')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('section', 'comments_cnt')) {
                    $table->bigInteger('comments_cnt');
                }
                if (!Schema::connection('mysql')->hasColumn('section', 'deleted_at')) {
                    $table->dateTime('deleted_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('section', 'sort_order')) {
                    $table->integer('sort_order')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('section', 'transfer_to_section')) {
                    $table->integer('transfer_to_section')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('section', 'transfered')) {
                    $table->boolean('transfered');
                }
                if (!Schema::connection('mysql')->hasColumn('section', 'content_short')) {
                    $table->string('content_short')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('section', 'content')) {
                    $table->text('content')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('section', 'user_id')) {
                    $table->bigInteger('user_id')->unsigned()->nullable()->index('section_user_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('section', 'react_data')) {
                    $table->text('react_data')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('section', 'settings')) {
                    $table->string('settings')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('section', 'seo_title')) {
                    $table->string('seo_title')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('section', 'seo_description')) {
                    $table->string('seo_description')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('section', 'seo_h1')) {
                    $table->string('seo_h1')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('section', 'seo_breadcrumbs')) {
                    $table->string('seo_breadcrumbs')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('section', 'filter_settings')) {
                    $table->text('filter_settings')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('section', 'sort_options')) {
                    $table->text('sort_options')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('section', 'object_id')) {
                    $table->integer('object_id')->nullable()->index('section_object_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('section', 'catalog_title')) {
                    $table->string('catalog_title')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('section', 'catalog_sort_by')) {
                    $table->string('catalog_sort_by')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('section', 'catalog_sort_order')) {
                    $table->boolean('catalog_sort_order')->nullable();
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
        Schema::connection('mysql')->drop('section');
    }

}