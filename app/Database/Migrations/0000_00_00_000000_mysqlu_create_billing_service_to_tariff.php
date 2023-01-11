<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqluCreateBillingServiceToTariff extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysqlu')->hasTable('billing_service_to_tariff')) {
            Schema::connection('mysqlu')->create('billing_service_to_tariff', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('billing_tariff_id')->unsigned()->index('billing_service_to_tariff_billing_tariff_id_foreign');
                $table->integer('billing_service_id')->unsigned()->index('billing_service_to_tariff_billing_service_id_foreign');
            });
        } else {
            Schema::connection('mysqlu')->table('billing_service_to_tariff', function (Blueprint $table) {
                if (!Schema::connection('mysqlu')->hasColumn('billing_service_to_tariff', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_service_to_tariff', 'billing_tariff_id')) {
                    $table->integer('billing_tariff_id')->unsigned()->index('billing_service_to_tariff_billing_tariff_id_foreign');
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_service_to_tariff', 'billing_service_id')) {
                    $table->integer('billing_service_id')->unsigned()->index('billing_service_to_tariff_billing_service_id_foreign');
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
        Schema::connection('mysqlu')->drop('billing_service_to_tariff');
    }

}