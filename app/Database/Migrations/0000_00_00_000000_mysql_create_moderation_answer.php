<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateModerationAnswer extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('moderation_answer')) {
            Schema::connection('mysql')->create('moderation_answer', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('object_id')->unsigned()->index('moderation_answer_object_id_foreign');
                $table->string('object');
                $table->bigInteger('author_id')->unsigned()->index('moderation_answer_author_id_foreign');
                $table->text('content');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->dateTime('confirmed_at')->nullable();
            });
        } else {
            Schema::connection('mysql')->table('moderation_answer', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('moderation_answer', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('moderation_answer', 'object_id')) {
                    $table->integer('object_id')->unsigned()->index('moderation_answer_object_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('moderation_answer', 'object')) {
                    $table->string('object');
                }
                if (!Schema::connection('mysql')->hasColumn('moderation_answer', 'author_id')) {
                    $table->bigInteger('author_id')->unsigned()->index('moderation_answer_author_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('moderation_answer', 'content')) {
                    $table->text('content');
                }
                if (!Schema::connection('mysql')->hasColumn('moderation_answer', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('moderation_answer', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('moderation_answer', 'confirmed_at')) {
                    $table->dateTime('confirmed_at')->nullable();
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
        Schema::connection('mysql')->drop('moderation_answer');
    }

}