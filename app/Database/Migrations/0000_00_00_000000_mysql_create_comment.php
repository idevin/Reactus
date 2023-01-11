<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateComment extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('comment')) {
            Schema::connection('mysql')->create('comment', function (Blueprint $table) {
                $table->increments('id');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->text('content');
                $table->bigInteger('author_id')->unsigned()->index('comment_author_id_foreign');
                $table->bigInteger('moderator_id')->unsigned()->nullable()->index('comment_moderator_id_foreign');
                $table->float('rating');
                $table->string('object');
                $table->dateTime('deleted_at')->nullable();
                $table->bigInteger('parent_id')->unsigned()->nullable()->index('comment_parent_id_foreign');
                $table->bigInteger('object_id')->index('comment_object_id_foreign');
                $table->boolean('moderated');
                $table->boolean('top');
                $table->boolean('status');
                $table->integer('site_id')->unsigned()->nullable()->index('comment_site_id_foreign');
                $table->boolean('pinned')->nullable();
                $table->text('react_data')->nullable();
            });
        } else {
            Schema::connection('mysql')->table('comment', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('comment', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('comment', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('comment', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('comment', 'content')) {
                    $table->text('content');
                }
                if (!Schema::connection('mysql')->hasColumn('comment', 'author_id')) {
                    $table->bigInteger('author_id')->unsigned()->index('comment_author_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('comment', 'moderator_id')) {
                    $table->bigInteger('moderator_id')->unsigned()->nullable()->index('comment_moderator_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('comment', 'rating')) {
                    $table->float('rating');
                }
                if (!Schema::connection('mysql')->hasColumn('comment', 'object')) {
                    $table->string('object');
                }
                if (!Schema::connection('mysql')->hasColumn('comment', 'deleted_at')) {
                    $table->dateTime('deleted_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('comment', 'parent_id')) {
                    $table->bigInteger('parent_id')->unsigned()->nullable()->index('comment_parent_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('comment', 'object_id')) {
                    $table->bigInteger('object_id')->index('comment_object_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('comment', 'moderated')) {
                    $table->boolean('moderated');
                }
                if (!Schema::connection('mysql')->hasColumn('comment', 'top')) {
                    $table->boolean('top');
                }
                if (!Schema::connection('mysql')->hasColumn('comment', 'status')) {
                    $table->boolean('status');
                }
                if (!Schema::connection('mysql')->hasColumn('comment', 'site_id')) {
                    $table->integer('site_id')->unsigned()->nullable()->index('comment_site_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('comment', 'pinned')) {
                    $table->boolean('pinned')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('comment', 'react_data')) {
                    $table->text('react_data')->nullable();
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
        Schema::connection('mysql')->drop('comment');
    }

}