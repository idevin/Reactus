<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqluCreateBillingSubscriptionService extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysqlu')->hasTable('billing_subscription_service')) {
            Schema::connection('mysqlu')->create('billing_subscription_service', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('site_id')->unsigned()->index('billing_subscription_service_site_id_foreign');
                $table->bigInteger('user_id')->unsigned()->index('billing_subscription_service_user_id_foreign');
                $table->integer('billing_service_id')->unsigned()->index('billing_subscription_service_billing_service_id_foreign');
                $table->integer('billing_subscription_id')->unsigned()->nullable()->index('billing_subscription_service_billing_subscription_id_foreign');
                $table->boolean('autorenew')->nullable();
                $table->boolean('pay_once');
                $table->dateTime('deleted_at')->nullable();
                $table->dateTime('mail_daily_sent')->nullable();
                $table->dateTime('mail_weekly_sent')->nullable();
                $table->dateTime('ends_at')->nullable();
                $table->dateTime('created_at')->nullable();
                $table->dateTime('next_write_off')->default("0000-00-00 00:00:00");
                $table->dateTime('updated_at')->nullable();
                $table->boolean('detached');
                $table->json('options')->nullable();
            });
        } else {
            Schema::connection('mysqlu')->table('billing_subscription_service', function (Blueprint $table) {
                if (!Schema::connection('mysqlu')->hasColumn('billing_subscription_service', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_subscription_service', 'site_id')) {
                    $table->integer('site_id')->unsigned()->index('billing_subscription_service_site_id_foreign');
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_subscription_service', 'user_id')) {
                    $table->bigInteger('user_id')->unsigned()->index('billing_subscription_service_user_id_foreign');
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_subscription_service', 'billing_service_id')) {
                    $table->integer('billing_service_id')->unsigned()->index('billing_subscription_service_billing_service_id_foreign');
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_subscription_service', 'billing_subscription_id')) {
                    $table->integer('billing_subscription_id')->unsigned()->nullable()->index('billing_subscription_service_billing_subscription_id_foreign');
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_subscription_service', 'autorenew')) {
                    $table->boolean('autorenew')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_subscription_service', 'pay_once')) {
                    $table->boolean('pay_once');
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_subscription_service', 'deleted_at')) {
                    $table->dateTime('deleted_at')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_subscription_service', 'mail_daily_sent')) {
                    $table->dateTime('mail_daily_sent')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_subscription_service', 'mail_weekly_sent')) {
                    $table->dateTime('mail_weekly_sent')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_subscription_service', 'ends_at')) {
                    $table->dateTime('ends_at')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_subscription_service', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_subscription_service', 'next_write_off')) {
                    $table->dateTime('next_write_off')->default("0000-00-00 00:00:00");
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_subscription_service', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_subscription_service', 'detached')) {
                    $table->boolean('detached');
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_subscription_service', 'options')) {
                    $table->json('options')->nullable();
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
        Schema::connection('mysqlu')->drop('billing_subscription_service');
    }

}