<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateModuleAnimationSettings extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('module_animation_settings')) {
            Schema::connection('mysql')->create('module_animation_settings', function (Blueprint $table) {
                        $table->increments('id');
        $table->text('settings');
        $table->integer('module_id')->unsigned()->index('module_animation_settings_module_id_foreign');
        $table->integer('module_template_id')->unsigned()->index('module_animation_settings_module_template_id_foreign');
            });
        } else {
            Schema::connection('mysql')->table('module_animation_settings', function (Blueprint $table) {
                        if (!Schema::connection('mysql')->hasColumn('module_animation_settings', 'id')) {
                        $table->increments('id');
        }
        if (!Schema::connection('mysql')->hasColumn('module_animation_settings', 'settings')) {
                        $table->text('settings');
        }
        if (!Schema::connection('mysql')->hasColumn('module_animation_settings', 'module_id')) {
                        $table->integer('module_id')->unsigned()->index('module_animation_settings_module_id_foreign');
        }
        if (!Schema::connection('mysql')->hasColumn('module_animation_settings', 'module_template_id')) {
                        $table->integer('module_template_id')->unsigned()->index('module_animation_settings_module_template_id_foreign');
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
        Schema::connection('mysql')->drop('module_animation_settings');
    }

}