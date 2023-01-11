<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqluCreateBillingService extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysqlu')->hasTable('billing_service')) {
            Schema::connection('mysqlu')->create('billing_service', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->text('description')->nullable();
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->boolean('pay_once');
                $table->float('price')->default("0.00");
                $table->boolean('period');
                $table->integer('period_amount');
                $table->integer('free_period_amount')->nullable();
                $table->integer('free_period')->nullable();
            });
        } else {
            Schema::connection('mysqlu')->table('billing_service', function (Blueprint $table) {
                if (!Schema::connection('mysqlu')->hasColumn('billing_service', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_service', 'name')) {
                    $table->string('name');
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_service', 'description')) {
                    $table->text('description')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_service', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_service', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_service', 'pay_once')) {
                    $table->boolean('pay_once');
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_service', 'price')) {
                    $table->float('price')->default("0.00");
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_service', 'period')) {
                    $table->boolean('period');
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_service', 'period_amount')) {
                    $table->integer('period_amount');
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_service', 'free_period_amount')) {
                    $table->integer('free_period_amount')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_service', 'free_period')) {
                    $table->integer('free_period')->nullable();
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
        Schema::connection('mysqlu')->drop('billing_service');
    }

}