<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqluCreateCurrency extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysqlu')->hasTable('currency')) {
            Schema::connection('mysqlu')->create('currency', function (Blueprint $table) {
                $table->string('iso_code');
                $table->integer('iso4217_code');
                $table->string('name');
                $table->float('points_value');
                $table->float('currency_value');
                $table->boolean('is_default');
                $table->increments('id');
                $table->string('sign')->nullable();
            });
        } else {
            Schema::connection('mysqlu')->table('currency', function (Blueprint $table) {
                if (!Schema::connection('mysqlu')->hasColumn('currency', 'iso_code')) {
                    $table->string('iso_code');
                }
                if (!Schema::connection('mysqlu')->hasColumn('currency', 'iso4217_code')) {
                    $table->integer('iso4217_code');
                }
                if (!Schema::connection('mysqlu')->hasColumn('currency', 'name')) {
                    $table->string('name');
                }
                if (!Schema::connection('mysqlu')->hasColumn('currency', 'points_value')) {
                    $table->float('points_value');
                }
                if (!Schema::connection('mysqlu')->hasColumn('currency', 'currency_value')) {
                    $table->float('currency_value');
                }
                if (!Schema::connection('mysqlu')->hasColumn('currency', 'is_default')) {
                    $table->boolean('is_default');
                }
                if (!Schema::connection('mysqlu')->hasColumn('currency', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysqlu')->hasColumn('currency', 'sign')) {
                    $table->string('sign')->nullable();
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
        Schema::connection('mysqlu')->drop('currency');
    }

}