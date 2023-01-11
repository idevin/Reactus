<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateOrderStatusToOrder extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('order_status_to_order')) {
            Schema::connection('mysql')->create('order_status_to_order', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('order_id')->unsigned()->index('order_status_to_order_order_id_foreign');
                $table->integer('status_id')->unsigned()->index('order_status_to_order_status_id_foreign');
            });
        } else {
            Schema::connection('mysql')->table('order_status_to_order', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('order_status_to_order', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('order_status_to_order', 'order_id')) {
                    $table->integer('order_id')->unsigned()->index('order_status_to_order_order_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('order_status_to_order', 'status_id')) {
                    $table->integer('status_id')->unsigned()->index('order_status_to_order_status_id_foreign');
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
        Schema::connection('mysql')->drop('order_status_to_order');
    }

}