<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqluFkBillingServiceToTariff extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysqlu')->table('billing_service_to_tariff', function (Blueprint $table) {
            if (!Utils::hasForeignKey('billing_service_to_tariff', 'billing_service_to_tariff_billing_service_id_foreign', 'mysqlu')) {
                $table->foreign('billing_service_id')->references('id')->on('billing_service')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('billing_service_to_tariff',
                'billing_service_to_tariff_billing_tariff_id_foreign', 'mysqlu')) {
                $table->foreign('billing_tariff_id')->references('id')->on('billing_tariff')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysqlu')->table('billing_service_to_tariff', function (Blueprint $table) {
            $table->dropForeign('billing_service_to_tariff_billing_service_id_foreign');
            $table->dropForeign('billing_service_to_tarrif_tariff_id_foreign');
        });
    }

}
