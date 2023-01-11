<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqluFkUserSubscriptionHistory extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysqlu')->table('user_subscription_history', function (Blueprint $table) {
            if (!Utils::hasForeignKey('user_subscription_history', 'user_subscription_history_billing_service_id_foreign', 'mysqlu')) {
                $table->foreign('billing_service_id')->references('id')->on('billing_service')
                    ->onUpdate('NO ACTION')->onDelete('SET NULL');
            }
            if (!Utils::hasForeignKey('user_subscription_history', 'user_subscription_history_user_id_foreign', 'mysqlu')) {
                $table->foreign('user_id')->references('id')->on(env('DBU_DATABASE') . '.' . 'user')
                    ->onUpdate('NO ACTION')->onDelete('SET NULL');
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
        Schema::connection('mysqlu')->table('user_subscription_history', function (Blueprint $table) {
            $table->dropForeign('user_subscription_history_billing_service_id_foreign');
            $table->dropForeign('user_subscription_history_user_id_foreign');
        });
    }

}
