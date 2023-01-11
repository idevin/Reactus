<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateMenu extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('menu')) {
            Schema::connection('mysql')->create('menu', function (Blueprint $table) {
                $table->increments('id');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->string('title');
                $table->string('url');
                $table->integer('site_id')->unsigned()->nullable()->index('menu_site_id_foreign');
                $table->boolean('as_tree');
                $table->string('alias');
                $table->string('image')->nullable();
                $table->integer('sort_order')->default("1");
                $table->integer('parent_id')->nullable()->index('menu_parent_id_foreign');
                $table->integer('lft')->nullable();
                $table->integer('rgt')->nullable();
                $table->integer('depth')->nullable();
                $table->boolean('disabled');
                $table->boolean('is_visible')->default("1");
            });
        } else {
            Schema::connection('mysql')->table('menu', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('menu', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('menu', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('menu', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('menu', 'title')) {
                    $table->string('title');
                }
                if (!Schema::connection('mysql')->hasColumn('menu', 'url')) {
                    $table->string('url');
                }
                if (!Schema::connection('mysql')->hasColumn('menu', 'site_id')) {
                    $table->integer('site_id')->unsigned()->nullable()->index('menu_site_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('menu', 'as_tree')) {
                    $table->boolean('as_tree');
                }
                if (!Schema::connection('mysql')->hasColumn('menu', 'alias')) {
                    $table->string('alias');
                }
                if (!Schema::connection('mysql')->hasColumn('menu', 'image')) {
                    $table->string('image')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('menu', 'sort_order')) {
                    $table->integer('sort_order')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('menu', 'parent_id')) {
                    $table->integer('parent_id')->nullable()->index('menu_parent_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('menu', 'lft')) {
                    $table->integer('lft')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('menu', 'rgt')) {
                    $table->integer('rgt')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('menu', 'depth')) {
                    $table->integer('depth')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('menu', 'disabled')) {
                    $table->boolean('disabled');
                }
                if (!Schema::connection('mysql')->hasColumn('menu', 'is_visible')) {
                    $table->boolean('is_visible')->default("1");
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
        Schema::connection('mysql')->drop('menu');
    }

}