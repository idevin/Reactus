<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateBlogCommentArchive extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('blog_comment_archive')) {
            Schema::connection('mysql')->create('blog_comment_archive', function (Blueprint $table) {
                $table->increments('id');
                $table->dateTime('from_date');
                $table->bigInteger('article_id')->unsigned()->index('blog_comment_archive_article_id_foreign');
            });
        } else {
            Schema::connection('mysql')->table('blog_comment_archive', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('blog_comment_archive', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_comment_archive', 'from_date')) {
                    $table->dateTime('from_date');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_comment_archive', 'article_id')) {
                    $table->bigInteger('article_id')->unsigned()->index('blog_comment_archive_article_id_foreign');
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
        Schema::connection('mysql')->drop('blog_comment_archive');
    }

}