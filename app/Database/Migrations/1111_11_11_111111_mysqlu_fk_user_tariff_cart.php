<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqluFkUserTariffCart extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysqlu')->table('user_tariff_cart', function (Blueprint $table) {
            if (!Utils::hasForeignKey('user_tariff_cart', 'user_tariff_cart_billing_service_id_foreign', 'mysqlu')) {
                $table->foreign('billing_service_id')->references('id')->on('billing_service')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('user_tariff_cart', 'user_tariff_cart_user_id_foreign', 'mysqlu')) {
                $table->foreign('user_id')->references('id')->on(env('DBU_DATABASE') . '.' . 'user')
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
        Schema::connection('mysqlu')->table('user_tariff_cart', function (Blueprint $table) {
            $table->dropForeign('user_tariff_cart_billing_service_id_foreign');
            $table->dropForeign('user_tariff_cart_user_id_foreign');
        });
    }

}
