<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateBlogSectionUser extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('blog_section_user')) {
            Schema::connection('mysql')->create('blog_section_user', function (Blueprint $table) {
                $table->increments('id');
                $table->bigInteger('user_id')->unsigned()->index('blog_section_user_user_id_foreign');
                $table->bigInteger('section_id')->unsigned()->index('blog_section_user_section_id_foreign');
            });
        } else {
            Schema::connection('mysql')->table('blog_section_user', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('blog_section_user', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_section_user', 'user_id')) {
                    $table->bigInteger('user_id')->unsigned()->index('blog_section_user_user_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('blog_section_user', 'section_id')) {
                    $table->bigInteger('section_id')->unsigned()->index('blog_section_user_section_id_foreign');
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
        Schema::connection('mysql')->drop('blog_section_user');
    }

}