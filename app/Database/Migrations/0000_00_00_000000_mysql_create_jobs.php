<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateJobs extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('jobs')) {
            Schema::connection('mysql')->create('jobs', function (Blueprint $table) {
                $table->increments('id');
                $table->string('queue');
                $table->text('payload');
                $table->boolean('attempts')->unsigned();
                $table->boolean('reserved')->unsigned();
                $table->integer('reserved_at')->unsigned()->nullable();
                $table->integer('available_at')->unsigned();
                $table->integer('created_at')->unsigned();
            });
        } else {
            Schema::connection('mysql')->table('jobs', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('jobs', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('jobs', 'queue')) {
                    $table->string('queue');
                }
                if (!Schema::connection('mysql')->hasColumn('jobs', 'payload')) {
                    $table->text('payload');
                }
                if (!Schema::connection('mysql')->hasColumn('jobs', 'attempts')) {
                    $table->boolean('attempts')->unsigned();
                }
                if (!Schema::connection('mysql')->hasColumn('jobs', 'reserved')) {
                    $table->boolean('reserved')->unsigned();
                }
                if (!Schema::connection('mysql')->hasColumn('jobs', 'reserved_at')) {
                    $table->integer('reserved_at')->unsigned()->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('jobs', 'available_at')) {
                    $table->integer('available_at')->unsigned();
                }
                if (!Schema::connection('mysql')->hasColumn('jobs', 'created_at')) {
                    $table->integer('created_at')->unsigned();
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
        Schema::connection('mysql')->drop('jobs');
    }

}