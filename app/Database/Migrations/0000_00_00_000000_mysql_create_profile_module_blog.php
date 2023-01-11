<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateProfileModuleBlog extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('profile_module_blog')) {
            Schema::connection('mysql')->create('profile_module_blog', function (Blueprint $table) {
                $table->bigInteger('user_id')->unsigned()->index('profile_module_blog_user_id_foreign');
                $table->integer('site_id')->unsigned()->index('profile_module_blog_site_id_foreign');
                $table->text('content');
            });
        } else {
            Schema::connection('mysql')->table('profile_module_blog', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('profile_module_blog', 'user_id')) {
                    $table->bigInteger('user_id')->unsigned()->index('profile_module_blog_user_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('profile_module_blog', 'site_id')) {
                    $table->integer('site_id')->unsigned()->index('profile_module_blog_site_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('profile_module_blog', 'content')) {
                    $table->text('content');
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
        Schema::connection('mysql')->drop('profile_module_blog');
    }

}