<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqluCreateUserSubscriptionHistory extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysqlu')->hasTable('user_subscription_history')) {
            Schema::connection('mysqlu')->create('user_subscription_history', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('billing_service_id')->unsigned()->nullable()->index('user_subscription_history_billing_service_id_foreign');
                $table->float('price')->default("0.00");
                $table->bigInteger('user_id')->unsigned()->nullable()->index('user_subscription_history_user_id_foreign');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
            });
        } else {
            Schema::connection('mysqlu')->table('user_subscription_history', function (Blueprint $table) {
                if (!Schema::connection('mysqlu')->hasColumn('user_subscription_history', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_subscription_history', 'billing_service_id')) {
                    $table->integer('billing_service_id')->unsigned()->nullable()->index('user_subscription_history_billing_service_id_foreign');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_subscription_history', 'price')) {
                    $table->float('price')->default("0.00");
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_subscription_history', 'user_id')) {
                    $table->bigInteger('user_id')->unsigned()->nullable()->index('user_subscription_history_user_id_foreign');
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_subscription_history', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('user_subscription_history', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
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
        Schema::connection('mysqlu')->drop('user_subscription_history');
    }

}