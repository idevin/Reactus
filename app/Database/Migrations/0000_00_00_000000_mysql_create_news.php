<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateNews extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('news')) {
            Schema::connection('mysql')->create('news', function (Blueprint $table) {
                $table->increments('id');
                $table->bigInteger('user_id')->unsigned()->index('news_user_id_foreign');
                $table->integer('site_id')->unsigned()->index('news_site_id_foreign');
                $table->string('title');
                $table->text('description');
                $table->text('content');
                $table->string('image')->nullable();
                $table->boolean('active')->default("1");
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->string('slug')->nullable();
                $table->integer('views');
            });
        } else {
            Schema::connection('mysql')->table('news', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('news', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('news', 'user_id')) {
                    $table->bigInteger('user_id')->unsigned()->index('news_user_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('news', 'site_id')) {
                    $table->integer('site_id')->unsigned()->index('news_site_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('news', 'title')) {
                    $table->string('title');
                }
                if (!Schema::connection('mysql')->hasColumn('news', 'description')) {
                    $table->text('description');
                }
                if (!Schema::connection('mysql')->hasColumn('news', 'content')) {
                    $table->text('content');
                }
                if (!Schema::connection('mysql')->hasColumn('news', 'image')) {
                    $table->string('image')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('news', 'active')) {
                    $table->boolean('active')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('news', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('news', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('news', 'slug')) {
                    $table->string('slug')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('news', 'views')) {
                    $table->integer('views');
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
        Schema::connection('mysql')->drop('news');
    }

}