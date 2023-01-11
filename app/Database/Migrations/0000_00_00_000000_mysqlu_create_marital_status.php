<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqluCreateMaritalStatus extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysqlu')->hasTable('marital_status')) {
            Schema::connection('mysqlu')->create('marital_status', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
            });
        } else {
            Schema::connection('mysqlu')->table('marital_status', function (Blueprint $table) {
                if (!Schema::connection('mysqlu')->hasColumn('marital_status', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysqlu')->hasColumn('marital_status', 'name')) {
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
        Schema::connection('mysqlu')->drop('marital_status');
    }

}