<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqluCreateBillingSubscription extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysqlu')->hasTable('billing_subscription')) {
            Schema::connection('mysqlu')->create('billing_subscription', function (Blueprint $table) {
                $table->increments('id');
                $table->bigInteger('user_id')->unsigned()->index('billing_subscription_user_id_foreign');
                $table->integer('site_id')->unsigned()->index('billing_subscription_site_id_foreign');
                $table->integer('billing_tariff_id')->unsigned()->index('billing_subscription_billing_tariff_id_foreign');
                $table->boolean('autorenew')->nullable();
                $table->dateTime('mail_daily_sent')->nullable();
                $table->dateTime('mail_weekly_sent')->nullable();
                $table->dateTime('ends_at')->nullable();
                $table->dateTime('trial_ends_at')->nullable();
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->dateTime('deleted_at')->nullable();
                $table->integer('billing_service_id')->unsigned()->index('billing_subscription_billing_service_id_foreign');
                $table->float('price')->default("0.00");
            });
        } else {
            Schema::connection('mysqlu')->table('billing_subscription', function (Blueprint $table) {
                if (!Schema::connection('mysqlu')->hasColumn('billing_subscription', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_subscription', 'user_id')) {
                    $table->bigInteger('user_id')->unsigned()->index('billing_subscription_user_id_foreign');
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_subscription', 'site_id')) {
                    $table->integer('site_id')->unsigned()->index('billing_subscription_site_id_foreign');
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_subscription', 'billing_tariff_id')) {
                    $table->integer('billing_tariff_id')->unsigned()->index('billing_subscription_billing_tariff_id_foreign');
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_subscription', 'autorenew')) {
                    $table->boolean('autorenew')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_subscription', 'mail_daily_sent')) {
                    $table->dateTime('mail_daily_sent')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_subscription', 'mail_weekly_sent')) {
                    $table->dateTime('mail_weekly_sent')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_subscription', 'ends_at')) {
                    $table->dateTime('ends_at')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_subscription', 'trial_ends_at')) {
                    $table->dateTime('trial_ends_at')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_subscription', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_subscription', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_subscription', 'deleted_at')) {
                    $table->dateTime('deleted_at')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_subscription', 'billing_service_id')) {
                    $table->integer('billing_service_id')->unsigned()->index('billing_subscription_billing_service_id_foreign');
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_subscription', 'price')) {
                    $table->float('price')->default("0.00");
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
        Schema::connection('mysqlu')->drop('billing_subscription');
    }

}