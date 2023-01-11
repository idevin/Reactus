<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateModule extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('module')) {
            Schema::connection('mysql')->create('module', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('class');
            });
        } else {
            Schema::connection('mysql')->table('module', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('module', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('module', 'name')) {
                    $table->string('name');
                }
                if (!Schema::connection('mysql')->hasColumn('module', 'class')) {
                    $table->string('class');
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
        Schema::connection('mysql')->drop('module');
    }

}