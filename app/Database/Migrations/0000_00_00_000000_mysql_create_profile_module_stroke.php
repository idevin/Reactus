<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateProfileModuleStroke extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('profile_module_stroke')) {
            Schema::connection('mysql')->create('profile_module_stroke', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('site_id')->unsigned()->index('profile_module_stroke_site_id_foreign');
                $table->bigInteger('user_id')->unsigned()->index('profile_module_stroke_user_id_foreign');
                $table->string('name');
                $table->string('stroke_type');
                $table->integer('sort_order')->default("1");
            });
        } else {
            Schema::connection('mysql')->table('profile_module_stroke', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('profile_module_stroke', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('profile_module_stroke', 'site_id')) {
                    $table->integer('site_id')->unsigned()->index('profile_module_stroke_site_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('profile_module_stroke', 'user_id')) {
                    $table->bigInteger('user_id')->unsigned()->index('profile_module_stroke_user_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('profile_module_stroke', 'name')) {
                    $table->string('name');
                }
                if (!Schema::connection('mysql')->hasColumn('profile_module_stroke', 'stroke_type')) {
                    $table->string('stroke_type');
                }
                if (!Schema::connection('mysql')->hasColumn('profile_module_stroke', 'sort_order')) {
                    $table->integer('sort_order')->default("1");
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
        Schema::connection('mysql')->drop('profile_module_stroke');
    }

}