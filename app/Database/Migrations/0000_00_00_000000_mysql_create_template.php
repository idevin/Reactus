<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateTemplate extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('template')) {
            Schema::connection('mysql')->create('template', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->boolean('default');
                $table->string('alias');
                $table->boolean('hidden');
                $table->integer('template_type')->nullable();
            });
        } else {
            Schema::connection('mysql')->table('template', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('template', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('template', 'name')) {
                    $table->string('name');
                }
                if (!Schema::connection('mysql')->hasColumn('template', 'default')) {
                    $table->boolean('default');
                }
                if (!Schema::connection('mysql')->hasColumn('template', 'alias')) {
                    $table->string('alias');
                }
                if (!Schema::connection('mysql')->hasColumn('template', 'hidden')) {
                    $table->boolean('hidden');
                }
                if (!Schema::connection('mysql')->hasColumn('template', 'template_type')) {
                    $table->integer('template_type')->nullable();
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
        Schema::connection('mysql')->drop('template');
    }

}