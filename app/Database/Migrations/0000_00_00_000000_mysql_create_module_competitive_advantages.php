<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateModuleCompetitiveAdvantages extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('module_competitive_advantages')) {
            Schema::connection('mysql')->create('module_competitive_advantages', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('site_id')->unsigned()->index('module_competitive_advantages_site_id_foreign');
                $table->integer('module_id')->unsigned()->nullable()->index('module_competitive_advantages_module_id_foreign');
                $table->integer('sort_order')->default("1");
                $table->string('name')->nullable();
                $table->string('template_id')->nullable()->index('module_competitive_advantages_template_id_foreign');
                $table->json('content_options')->nullable();
                $table->boolean('full_screen');
                $table->json('settings')->nullable();
            });
        } else {
            Schema::connection('mysql')->table('module_competitive_advantages', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('module_competitive_advantages', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('module_competitive_advantages', 'site_id')) {
                    $table->integer('site_id')->unsigned()->index('module_competitive_advantages_site_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('module_competitive_advantages', 'module_id')) {
                    $table->integer('module_id')->unsigned()->nullable()->index('module_competitive_advantages_module_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('module_competitive_advantages', 'sort_order')) {
                    $table->integer('sort_order')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('module_competitive_advantages', 'name')) {
                    $table->string('name')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('module_competitive_advantages', 'template_id')) {
                    $table->string('template_id')->nullable()->index('module_competitive_advantages_template_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('module_competitive_advantages', 'content_options')) {
                    $table->json('content_options')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('module_competitive_advantages', 'full_screen')) {
                    $table->boolean('full_screen');
                }
                if (!Schema::connection('mysql')->hasColumn('module_competitive_advantages', 'settings')) {
                    $table->json('settings')->nullable();
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
        Schema::connection('mysql')->drop('module_competitive_advantages');
    }

}