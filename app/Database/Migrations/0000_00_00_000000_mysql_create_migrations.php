<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateMigrations extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('migrations')) {
            Schema::connection('mysql')->create('migrations', function (Blueprint $table) {
                $table->string('migration');
                $table->integer('batch');
            });
        } else {
            Schema::connection('mysql')->table('migrations', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('migrations', 'migration')) {
                    $table->string('migration');
                }
                if (!Schema::connection('mysql')->hasColumn('migrations', 'batch')) {
                    $table->integer('batch');
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
        Schema::connection('mysql')->drop('migrations');
    }

}