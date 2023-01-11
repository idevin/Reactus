<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqluFkBillingSubscriptionService extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysqlu')->table('billing_subscription_service', function (Blueprint $table) {
            if (!Utils::hasForeignKey('billing_subscription_service', 'billing_subscription_service_billing_service_id_foreign', 'mysqlu')) {
                $table->foreign('billing_service_id')->references('id')->on('billing_service')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('billing_subscription_service', 'billing_subscription_service_billing_subscription_id_foreign', 'mysqlu')) {
                $table->foreign('billing_subscription_id')->references('id')->on('billing_subscription')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('billing_subscription_service', 'billing_subscription_service_site_id_foreign', 'mysqlu')) {
                $table->foreign('site_id')->references('id')->on(env('DB_DATABASE') . '.' . 'site')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('billing_subscription_service', 'billing_subscription_service_user_id_foreign', 'mysqlu')) {
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
        Schema::connection('mysqlu')->table('billing_subscription_service', function (Blueprint $table) {
            $table->dropForeign('billing_subscription_service_billing_service_id_foreign');
            $table->dropForeign('billing_subscription_service_billing_subscription_id_foreign');
            $table->dropForeign('billing_subscription_service_site_id_foreign');
            $table->dropForeign('billing_subscription_service_user_id_foreign');
        });
    }

}
