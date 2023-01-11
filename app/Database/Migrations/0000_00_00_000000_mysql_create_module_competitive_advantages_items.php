<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateModuleCompetitiveAdvantagesItems extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('module_competitive_advantages_items')) {
            Schema::connection('mysql')->create('module_competitive_advantages_items', function (Blueprint $table) {
                $table->increments('id');
                $table->text('content_options')->nullable();
                $table->string('name')->nullable();
                $table->text('description')->nullable();
                $table->integer('advantages_id')->unsigned()->index('module_competitive_advantages_items_advantages_id_foreign');
                $table->integer('sort_order')->default("1");
            });
        } else {
            Schema::connection('mysql')->table('module_competitive_advantages_items', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('module_competitive_advantages_items', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('module_competitive_advantages_items', 'content_options')) {
                    $table->text('content_options')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('module_competitive_advantages_items', 'name')) {
                    $table->string('name')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('module_competitive_advantages_items', 'description')) {
                    $table->text('description')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('module_competitive_advantages_items', 'advantages_id')) {
                    $table->integer('advantages_id')->unsigned()->index('module_competitive_advantages_items_advantages_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('module_competitive_advantages_items', 'sort_order')) {
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
        Schema::connection('mysql')->drop('module_competitive_advantages_items');
    }

}