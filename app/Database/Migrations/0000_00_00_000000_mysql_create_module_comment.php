<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateModuleComment extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('module_comment')) {
            Schema::connection('mysql')->create('module_comment', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->nullable();
                $table->integer('site_id')->unsigned()->index('module_comment_site_id_foreign');
                $table->boolean('sort_order')->default("1");
                $table->boolean('sort_by')->default("1");
                $table->boolean('view')->default("1");
                $table->integer('module_id')->unsigned()->nullable()->index('module_comment_module_id_foreign');
                $table->boolean('block_view');
            });
        } else {
            Schema::connection('mysql')->table('module_comment', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('module_comment', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('module_comment', 'name')) {
                    $table->string('name')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('module_comment', 'site_id')) {
                    $table->integer('site_id')->unsigned()->index('module_comment_site_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('module_comment', 'sort_order')) {
                    $table->boolean('sort_order')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('module_comment', 'sort_by')) {
                    $table->boolean('sort_by')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('module_comment', 'view')) {
                    $table->boolean('view')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('module_comment', 'module_id')) {
                    $table->integer('module_id')->unsigned()->nullable()->index('module_comment_module_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('module_comment', 'block_view')) {
                    $table->boolean('block_view');
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
        Schema::connection('mysql')->drop('module_comment');
    }

}