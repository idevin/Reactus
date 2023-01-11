<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateArticleImages extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('article_images')) {
            Schema::connection('mysql')->create('article_images', function (Blueprint $table) {
                $table->increments('id');
                $table->bigInteger('article_id')->unsigned()->index('article_images_article_id_foreign');
                $table->string('image');
                $table->string('title')->nullable();
                $table->string('description')->nullable();
            });
        } else {
            Schema::connection('mysql')->table('article_images', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('article_images', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('article_images', 'article_id')) {
                    $table->bigInteger('article_id')->unsigned()->index('article_images_article_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('article_images', 'image')) {
                    $table->string('image');
                }
                if (!Schema::connection('mysql')->hasColumn('article_images', 'title')) {
                    $table->string('title')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('article_images', 'description')) {
                    $table->string('description')->nullable();
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
        Schema::connection('mysql')->drop('article_images');
    }

}