<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateModuleFeedback extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('module_feedback')) {
            Schema::connection('mysql')->create('module_feedback', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('site_id')->unsigned()->index('module_feedback_site_id_foreign');
                $table->integer('sort_order')->default("1");
                $table->string('name')->nullable();
                $table->integer('field_group_id')->unsigned()->index('module_feedback_field_group_id_foreign');
                $table->boolean('registration');
                $table->boolean('modal');
                $table->integer('module_id')->unsigned()->nullable()->index('module_feedback_module_id_foreign');
            });
        } else {
            Schema::connection('mysql')->table('module_feedback', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('module_feedback', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('module_feedback', 'site_id')) {
                    $table->integer('site_id')->unsigned()->index('module_feedback_site_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('module_feedback', 'sort_order')) {
                    $table->integer('sort_order')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('module_feedback', 'name')) {
                    $table->string('name')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('module_feedback', 'field_group_id')) {
                    $table->integer('field_group_id')->unsigned()->index('module_feedback_field_group_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('module_feedback', 'registration')) {
                    $table->boolean('registration');
                }
                if (!Schema::connection('mysql')->hasColumn('module_feedback', 'modal')) {
                    $table->boolean('modal');
                }
                if (!Schema::connection('mysql')->hasColumn('module_feedback', 'module_id')) {
                    $table->integer('module_id')->unsigned()->nullable()->index('module_feedback_module_id_foreign');
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
        Schema::connection('mysql')->drop('module_feedback');
    }

}