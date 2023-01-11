<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqluCreateUserTariffCart extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysqlu')->hasTable('user_tariff_cart')) {
            Schema::connection('mysqlu')->create('user_tariff_cart', function (Blueprint $table) {
                $table->increments('id');
                $table->bigInteger('user_id')->unsigned()->index('user_tariff_cart_user_id_foreign');
                $table->integer('billing_service_id')->unsigned()->index('user_tariff_cart_billing_service_id_foreign');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->integer('count');
            });
        } else {
            Schema::connection('mysqlu')->table('user_tariff_cart', function (Blueprint $table) {
                if (!Schema::connection('mysqlu')->hasColumn('user_tariff_cart', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_tariff_cart', 'user_id')) {
                    $table->bigInteger('user_id')->unsigned()->index('user_tariff_cart_user_id_foreign');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_tariff_cart', 'billing_service_id')) {
                    $table->integer('billing_service_id')->unsigned()->index('user_tariff_cart_billing_service_id_foreign');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_tariff_cart', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_tariff_cart', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_tariff_cart', 'count')) {
                    $table->integer('count');
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
        Schema::connection('mysqlu')->drop('user_tariff_cart');
    }

}