<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateTemplateScheme extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('template_scheme')) {
            Schema::connection('mysql')->create('template_scheme', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->nullable();
                $table->boolean('default');
                $table->boolean('default_global');
                $table->json('colors')->nullable();
                $table->boolean('is_user_defined');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
            });
        } else {
            Schema::connection('mysql')->table('template_scheme', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('template_scheme', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('template_scheme', 'name')) {
                    $table->string('name')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('template_scheme', 'default')) {
                    $table->boolean('default');
                }
                if (!Schema::connection('mysql')->hasColumn('template_scheme', 'default_global')) {
                    $table->boolean('default_global');
                }
                if (!Schema::connection('mysql')->hasColumn('template_scheme', 'colors')) {
                    $table->json('colors')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('template_scheme', 'is_user_defined')) {
                    $table->boolean('is_user_defined');
                }
                if (!Schema::connection('mysql')->hasColumn('template_scheme', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('template_scheme', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
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
        Schema::connection('mysql')->drop('template_scheme');
    }

}