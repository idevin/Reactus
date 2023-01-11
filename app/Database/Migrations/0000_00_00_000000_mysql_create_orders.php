<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateOrders extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('orders')) {
            Schema::connection('mysql')->create('orders', function (Blueprint $table) {
                $table->increments('id');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->string('name');
                $table->string('email');
                $table->string('phone');
                $table->text('items');
                $table->float('total_price')->default("0.00");
                $table->float('total_discount')->default("0.00");
                $table->string('delivery_address');
                $table->dateTime('delivery_time')->nullable();
                $table->integer('site_id')->unsigned()->index('orders_site_id_foreign');
                $table->bigInteger('user_id')->unsigned()->index('orders_user_id_foreign');
            });
        } else {
            Schema::connection('mysql')->table('orders', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('orders', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('orders', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('orders', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('orders', 'name')) {
                    $table->string('name');
                }
                if (!Schema::connection('mysql')->hasColumn('orders', 'email')) {
                    $table->string('email');
                }
                if (!Schema::connection('mysql')->hasColumn('orders', 'phone')) {
                    $table->string('phone');
                }
                if (!Schema::connection('mysql')->hasColumn('orders', 'items')) {
                    $table->text('items');
                }
                if (!Schema::connection('mysql')->hasColumn('orders', 'total_price')) {
                    $table->float('total_price')->default("0.00");
                }
                if (!Schema::connection('mysql')->hasColumn('orders', 'total_discount')) {
                    $table->float('total_discount')->default("0.00");
                }
                if (!Schema::connection('mysql')->hasColumn('orders', 'delivery_address')) {
                    $table->string('delivery_address');
                }
                if (!Schema::connection('mysql')->hasColumn('orders', 'delivery_time')) {
                    $table->dateTime('delivery_time')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('orders', 'site_id')) {
                    $table->integer('site_id')->unsigned()->index('orders_site_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('orders', 'user_id')) {
                    $table->bigInteger('user_id')->unsigned()->index('orders_user_id_foreign');
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
        Schema::connection('mysql')->drop('orders');
    }

}