<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateModuleSlogan extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('module_slogan')) {
            Schema::connection('mysql')->create('module_slogan', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('site_id')->unsigned()->index('module_slogan_site_id_foreign');
                $table->integer('sort_order')->default("1");
                $table->string('name')->nullable();
                $table->json('content_options')->nullable();
            });
        } else {
            Schema::connection('mysql')->table('module_slogan', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('module_slogan', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('module_slogan', 'site_id')) {
                    $table->integer('site_id')->unsigned()->index('module_slogan_site_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('module_slogan', 'sort_order')) {
                    $table->integer('sort_order')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('module_slogan', 'name')) {
                    $table->string('name')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('module_slogan', 'content_options')) {
                    $table->json('content_options')->nullable();
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
        Schema::connection('mysql')->drop('module_slogan');
    }

}