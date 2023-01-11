<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateArticleRevision extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('article_revision')) {
            Schema::connection('mysql')->create('article_revision', function (Blueprint $table) {
                $table->increments('id');
                $table->bigInteger('article_id')->unsigned()->index('article_revision_article_id_foreign');
                $table->string('title');
                $table->string('content');
                $table->text('react_data')->nullable();
                $table->integer('count_symbols');
                $table->integer('count_images');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->bigInteger('author_id')->unsigned()->index('article_revision_author_id_foreign');
                $table->bigInteger('section_id')->unsigned()->index('article_revision_section_id_foreign');
            });
        } else {
            Schema::connection('mysql')->table('article_revision', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('article_revision', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('article_revision', 'article_id')) {
                    $table->bigInteger('article_id')->unsigned()->index('article_revision_article_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('article_revision', 'title')) {
                    $table->string('title');
                }
                if (!Schema::connection('mysql')->hasColumn('article_revision', 'content')) {
                    $table->string('content');
                }
                if (!Schema::connection('mysql')->hasColumn('article_revision', 'react_data')) {
                    $table->text('react_data')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('article_revision', 'count_symbols')) {
                    $table->integer('count_symbols');
                }
                if (!Schema::connection('mysql')->hasColumn('article_revision', 'count_images')) {
                    $table->integer('count_images');
                }
                if (!Schema::connection('mysql')->hasColumn('article_revision', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('article_revision', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('article_revision', 'author_id')) {
                    $table->bigInteger('author_id')->unsigned()->index('article_revision_author_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('article_revision', 'section_id')) {
                    $table->bigInteger('section_id')->unsigned()->index('article_revision_section_id_foreign');
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
        Schema::connection('mysql')->drop('article_revision');
    }

}