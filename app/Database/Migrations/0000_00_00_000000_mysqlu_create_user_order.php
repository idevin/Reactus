<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqluCreateUserOrder extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysqlu')->hasTable('user_order')) {
            Schema::connection('mysqlu')->create('user_order', function (Blueprint $table) {
                $table->increments('id');
                $table->bigInteger('user_id')->unsigned()->nullable()->index('user_order_user_id_foreign');
                $table->integer('site_id')->unsigned()->nullable()->index('user_order_site_id_foreign');
                $table->string('internal_order_id')->index('user_order_internal_order_id_foreign');
                $table->string('merchant_order_id')->index('user_order_merchant_order_id_foreign');
                $table->boolean('paid');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->text('description')->nullable();
                $table->decimal('price');
                $table->integer('billing_discount_id')->unsigned()->nullable()->index('user_order_billing_discount_id_foreign');
                $table->float('points')->default("0.00");
                $table->integer('payment_type');
            });
        } else {
            Schema::connection('mysqlu')->table('user_order', function (Blueprint $table) {
                if (!Schema::connection('mysqlu')->hasColumn('user_order', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_order', 'user_id')) {
                    $table->bigInteger('user_id')->unsigned()->nullable()->index('user_order_user_id_foreign');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_order', 'site_id')) {
                    $table->integer('site_id')->unsigned()->nullable()->index('user_order_site_id_foreign');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_order', 'internal_order_id')) {
                    $table->string('internal_order_id')->index('user_order_internal_order_id_foreign');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_order', 'merchant_order_id')) {
                    $table->string('merchant_order_id')->index('user_order_merchant_order_id_foreign');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_order', 'paid')) {
                    $table->boolean('paid');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_order', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_order', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_order', 'description')) {
                    $table->text('description')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_order', 'price')) {
                    $table->decimal('price');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_order', 'billing_discount_id')) {
                    $table->integer('billing_discount_id')->unsigned()->nullable()->index('user_order_billing_discount_id_foreign');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_order', 'points')) {
                    $table->float('points')->default("0.00");
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_order', 'payment_type')) {
                    $table->integer('payment_type');
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
        Schema::connection('mysqlu')->drop('user_order');
    }

}