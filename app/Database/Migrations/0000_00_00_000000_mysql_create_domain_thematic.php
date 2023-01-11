<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateDomainThematic extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('domain_thematic')) {
            Schema::connection('mysql')->create('domain_thematic', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
            });
        } else {
            Schema::connection('mysql')->table('domain_thematic', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('domain_thematic', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('domain_thematic', 'name')) {
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
        Schema::connection('mysql')->drop('domain_thematic');
    }

}