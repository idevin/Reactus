<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqluCreateAddress extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysqlu')->hasTable('address')) {
            Schema::connection('mysqlu')->create('address', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
            });
        } else {
            Schema::connection('mysqlu')->table('address', function (Blueprint $table) {
                if (!Schema::connection('mysqlu')->hasColumn('address', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysqlu')->hasColumn('address', 'name')) {
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
        Schema::connection('mysqlu')->drop('address');
    }

}