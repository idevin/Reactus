<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateTopSlider extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('top_slider')) {
            Schema::connection('mysql')->create('top_slider', function (Blueprint $table) {
                $table->increments('id');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->string('title');
                $table->string('url');
                $table->string('image');
                $table->boolean('position');
                $table->bigInteger('article_id')->index('top_slider_article_id_foreign');
                $table->string('domain');
            });
        } else {
            Schema::connection('mysql')->table('top_slider', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('top_slider', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('top_slider', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('top_slider', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('top_slider', 'title')) {
                    $table->string('title');
                }
                if (!Schema::connection('mysql')->hasColumn('top_slider', 'url')) {
                    $table->string('url');
                }
                if (!Schema::connection('mysql')->hasColumn('top_slider', 'image')) {
                    $table->string('image');
                }
                if (!Schema::connection('mysql')->hasColumn('top_slider', 'position')) {
                    $table->boolean('position');
                }
                if (!Schema::connection('mysql')->hasColumn('top_slider', 'article_id')) {
                    $table->bigInteger('article_id')->index('top_slider_article_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('top_slider', 'domain')) {
                    $table->string('domain');
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
        Schema::connection('mysql')->drop('top_slider');
    }

}