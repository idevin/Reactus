<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateDomainVolume extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('domain_volume')) {
            Schema::connection('mysql')->create('domain_volume', function (Blueprint $table) {
                $table->increments('id');
                $table->string('uuid');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->float('size')->default("0.1");
            });
        } else {
            Schema::connection('mysql')->table('domain_volume', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('domain_volume', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('domain_volume', 'uuid')) {
                    $table->string('uuid');
                }
                if (!Schema::connection('mysql')->hasColumn('domain_volume', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('domain_volume', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('domain_volume', 'size')) {
                    $table->float('size')->default("0.1");
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
        Schema::connection('mysql')->drop('domain_volume');
    }

}