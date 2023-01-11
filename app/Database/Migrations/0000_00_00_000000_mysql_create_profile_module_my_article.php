<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateProfileModuleMyArticle extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('profile_module_my_article')) {
            Schema::connection('mysql')->create('profile_module_my_article', function (Blueprint $table) {
                $table->increments('id');
                $table->bigInteger('user_id')->unsigned()->index('profile_module_my_article_user_id_foreign');
                $table->integer('site_id')->unsigned()->index('profile_module_my_article_site_id_foreign');
                $table->boolean('view');
                $table->boolean('sort_by');
                $table->boolean('sort_order');
            });
        } else {
            Schema::connection('mysql')->table('profile_module_my_article', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('profile_module_my_article', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('profile_module_my_article', 'user_id')) {
                    $table->bigInteger('user_id')->unsigned()->index('profile_module_my_article_user_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('profile_module_my_article', 'site_id')) {
                    $table->integer('site_id')->unsigned()->index('profile_module_my_article_site_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('profile_module_my_article', 'view')) {
                    $table->boolean('view');
                }
                if (!Schema::connection('mysql')->hasColumn('profile_module_my_article', 'sort_by')) {
                    $table->boolean('sort_by');
                }
                if (!Schema::connection('mysql')->hasColumn('profile_module_my_article', 'sort_order')) {
                    $table->boolean('sort_order');
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
        Schema::connection('mysql')->drop('profile_module_my_article');
    }

}