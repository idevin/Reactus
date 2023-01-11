<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateBlogComment extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('blog_comment')) {
            Schema::connection('mysql')->create('blog_comment', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->text('content');
                $table->text('react_data')->nullable();
                $table->bigInteger('author_id')->unsigned()->index('blog_comment_author_id_foreign');
                $table->integer('rating')->unsigned();
                $table->string('object');
                $table->integer('object_id')->unsigned()->index('blog_comment_object_id_foreign');
                $table->integer('site_id')->unsigned()->index('blog_comment_site_id_foreign');
                $table->boolean('status')->default("1");
                $table->boolean('pinned')->nullable();
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->boolean('top');
                $table->boolean('moderated');
                $table->bigInteger('parent_id')->unsigned()->nullable()->index('blog_comment_parent_id_foreign');
                $table->bigInteger('moderator_id')->unsigned()->nullable()->index('blog_comment_moderator_id_foreign');
            });
        } else {
            Schema::connection('mysql')->table('blog_comment', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('blog_comment', 'id')) {
                    $table->bigIncrements('id');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_comment', 'content')) {
                    $table->text('content');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_comment', 'react_data')) {
                    $table->text('react_data')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_comment', 'author_id')) {
                    $table->bigInteger('author_id')->unsigned()->index('blog_comment_author_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_comment', 'rating')) {
                    $table->integer('rating')->unsigned();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_comment', 'object')) {
                    $table->string('object');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_comment', 'object_id')) {
                    $table->integer('object_id')->unsigned()->index('blog_comment_object_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_comment', 'site_id')) {
                    $table->integer('site_id')->unsigned()->index('blog_comment_site_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_comment', 'status')) {
                    $table->boolean('status')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('blog_comment', 'pinned')) {
                    $table->boolean('pinned')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_comment', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_comment', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('blog_comment', 'top')) {
                    $table->boolean('top');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_comment', 'moderated')) {
                    $table->boolean('moderated');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_comment', 'parent_id')) {
                    $table->bigInteger('parent_id')->unsigned()->nullable()->index('blog_comment_parent_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_comment', 'moderator_id')) {
                    $table->bigInteger('moderator_id')->unsigned()->nullable()->index('blog_comment_moderator_id_foreign');
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
        Schema::connection('mysql')->drop('blog_comment');
    }

}