<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqluFkBillingSubscription extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysqlu')->table('billing_subscription', function (Blueprint $table) {
            if (!Utils::hasForeignKey('billing_subscription', 'billing_subscription_billing_tariff_id_foreign', 'mysqlu')) {
                $table->foreign('billing_tariff_id')->references('id')->on('billing_tariff')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('billing_subscription', 'billing_subscription_site_id_foreign', 'mysqlu')) {
                $table->foreign('site_id')->references('id')->on(env('DB_DATABASE') . '.' . 'site')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('billing_subscription', 'billing_subscription_user_id_foreign', 'mysqlu')) {
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
        Schema::connection('mysqlu')->table('billing_subscription', function (Blueprint $table) {
            $table->dropForeign('billing_subscription_billing_tariff_id_foreign');
            $table->dropForeign('billing_subscription_site_id_foreign');
            $table->dropForeign('billing_subscription_user_id_foreign');
        });
    }

}
