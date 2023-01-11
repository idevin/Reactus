<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqluCreateWorkPlace extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysqlu')->hasTable('work_place')) {
            Schema::connection('mysqlu')->create('work_place', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
            });
        } else {
            Schema::connection('mysqlu')->table('work_place', function (Blueprint $table) {
                if (!Schema::connection('mysqlu')->hasColumn('work_place', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysqlu')->hasColumn('work_place', 'name')) {
                    $table->string('name');
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
        Schema::connection('mysqlu')->drop('work_place');
    }

}