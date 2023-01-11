<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateSubscribeArticles extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('subscribe_articles')) {
            Schema::connection('mysql')->create('subscribe_articles', function (Blueprint $table) {
                $table->increments('id');
                $table->bigInteger('user_id')->unsigned()->index('subscribe_articles_user_id_foreign');
                $table->bigInteger('article_id')->unsigned()->index('subscribe_articles_article_id_foreign');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
            });
        } else {
            Schema::connection('mysql')->table('subscribe_articles', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('subscribe_articles', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('subscribe_articles', 'user_id')) {
                    $table->bigInteger('user_id')->unsigned()->index('subscribe_articles_user_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('subscribe_articles', 'article_id')) {
                    $table->bigInteger('article_id')->unsigned()->index('subscribe_articles_article_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('subscribe_articles', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('subscribe_articles', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
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
        Schema::connection('mysql')->drop('subscribe_articles');
    }

}