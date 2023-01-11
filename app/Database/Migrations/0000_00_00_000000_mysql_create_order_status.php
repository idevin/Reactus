<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateOrderStatus extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('order_status')) {
            Schema::connection('mysql')->create('order_status', function (Blueprint $table) {
                $table->increments('id');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->string('name');
                $table->string('description')->nullable();
                $table->string('action');
            });
        } else {
            Schema::connection('mysql')->table('order_status', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('order_status', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('order_status', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('order_status', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('order_status', 'name')) {
                    $table->string('name');
                }
                if (!Schema::connection('mysql')->hasColumn('order_status', 'description')) {
                    $table->string('description')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('order_status', 'action')) {
                    $table->string('action');
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
        Schema::connection('mysql')->drop('order_status');
    }

}