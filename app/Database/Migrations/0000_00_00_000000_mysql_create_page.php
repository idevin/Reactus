<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreatePage extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('page')) {
            Schema::connection('mysql')->create('page', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('site_id')->unsigned()->index('page_site_id_foreign');
                $table->bigInteger('user_id')->unsigned()->nullable()->index('page_user_id_foreign');
                $table->string('title');
                $table->string('slug');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->boolean('is_edit_mode');
                $table->boolean('is_active')->default("1");
                $table->string('seo_title')->nullable();
                $table->string('seo_description')->nullable();
                $table->string('seo_keywords')->nullable();
                $table->boolean('is_home');
            });
        } else {
            Schema::connection('mysql')->table('page', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('page', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('page', 'site_id')) {
                    $table->integer('site_id')->unsigned()->index('page_site_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('page', 'user_id')) {
                    $table->bigInteger('user_id')->unsigned()->nullable()->index('page_user_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('page', 'title')) {
                    $table->string('title');
                }
                if (!Schema::connection('mysql')->hasColumn('page', 'slug')) {
                    $table->string('slug');
                }
                if (!Schema::connection('mysql')->hasColumn('page', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('page', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('page', 'is_edit_mode')) {
                    $table->boolean('is_edit_mode');
                }
                if (!Schema::connection('mysql')->hasColumn('page', 'is_active')) {
                    $table->boolean('is_active')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('page', 'seo_title')) {
                    $table->string('seo_title')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('page', 'seo_description')) {
                    $table->string('seo_description')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('page', 'seo_keywords')) {
                    $table->string('seo_keywords')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('page', 'is_home')) {
                    $table->boolean('is_home');
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
        Schema::connection('mysql')->drop('page');
    }

}