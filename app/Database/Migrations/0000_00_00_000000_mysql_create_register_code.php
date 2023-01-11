<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateRegisterCode extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('register_code')) {
            Schema::connection('mysql')->create('register_code', function (Blueprint $table) {
                $table->increments('id');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->string('field');
                $table->string('value');
                $table->string('code');
                $table->boolean('sent');
            });
        } else {
            Schema::connection('mysql')->table('register_code', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('register_code', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('register_code', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('register_code', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('register_code', 'field')) {
                    $table->string('field');
                }
                if (!Schema::connection('mysql')->hasColumn('register_code', 'value')) {
                    $table->string('value');
                }
                if (!Schema::connection('mysql')->hasColumn('register_code', 'code')) {
                    $table->string('code');
                }
                if (!Schema::connection('mysql')->hasColumn('register_code', 'sent')) {
                    $table->boolean('sent');
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
        Schema::connection('mysql')->drop('register_code');
    }

}