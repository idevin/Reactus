<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateArticleGroupArticle extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('article_group_article')) {
            Schema::connection('mysql')->create('article_group_article', function (Blueprint $table) {
                $table->increments('id');
                $table->bigInteger('article_id')->unsigned()->index('article_group_article_article_id_foreign');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->integer('article_group_id')->unsigned()->index('article_group_article_article_group_id_foreign');
                $table->string('name')->nullable();
                $table->integer('sort_order')->default("1");
            });
        } else {
            Schema::connection('mysql')->table('article_group_article', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('article_group_article', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('article_group_article', 'article_id')) {
                    $table->bigInteger('article_id')->unsigned()->index('article_group_article_article_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('article_group_article', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('article_group_article', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('article_group_article', 'article_group_id')) {
                    $table->integer('article_group_id')->unsigned()->index('article_group_article_article_group_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('article_group_article', 'name')) {
                    $table->string('name')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('article_group_article', 'sort_order')) {
                    $table->integer('sort_order')->default("1");
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
        Schema::connection('mysql')->drop('article_group_article');
    }

}