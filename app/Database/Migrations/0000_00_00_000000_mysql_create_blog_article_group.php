<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateBlogArticleGroup extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('blog_article_group')) {
            Schema::connection('mysql')->create('blog_article_group', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->bigInteger('user_id')->unsigned()->index('blog_article_group_user_id_foreign');
                $table->integer('site_id')->unsigned()->index('blog_article_group_site_id_foreign');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->bigInteger('article_id')->unsigned()->index('blog_article_group_article_id_foreign');
            });
        } else {
            Schema::connection('mysql')->table('blog_article_group', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('blog_article_group', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_article_group', 'name')) {
                    $table->string('name');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_article_group', 'user_id')) {
                    $table->bigInteger('user_id')->unsigned()->index('blog_article_group_user_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_article_group', 'site_id')) {
                    $table->integer('site_id')->unsigned()->index('blog_article_group_site_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_article_group', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_article_group', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_article_group', 'article_id')) {
                    $table->bigInteger('article_id')->unsigned()->index('blog_article_group_article_id_foreign');
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
        Schema::connection('mysql')->drop('blog_article_group');
    }

}