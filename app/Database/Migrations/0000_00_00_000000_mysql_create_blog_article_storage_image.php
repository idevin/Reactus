<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateBlogArticleStorageImage extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('blog_article_storage_image')) {
            Schema::connection('mysql')->create('blog_article_storage_image', function (Blueprint $table) {
                $table->increments('id');
                $table->bigInteger('article_id')->unsigned()->index('blog_article_storage_image_article_id_foreign');
                $table->integer('storage_file_id')->unsigned()->nullable()->index('blog_article_storage_image_storage_file_id_foreign');
                $table->dateTime('deleted_at')->nullable();
                $table->integer('sort_order');
            });
        } else {
            Schema::connection('mysql')->table('blog_article_storage_image', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('blog_article_storage_image', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_article_storage_image', 'article_id')) {
                    $table->bigInteger('article_id')->unsigned()->index('blog_article_storage_image_article_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_article_storage_image', 'storage_file_id')) {
                    $table->integer('storage_file_id')->unsigned()->nullable()->index('blog_article_storage_image_storage_file_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_article_storage_image', 'deleted_at')) {
                    $table->dateTime('deleted_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_article_storage_image', 'sort_order')) {
                    $table->integer('sort_order');
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
        Schema::connection('mysql')->drop('blog_article_storage_image');
    }

}