<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqluCreateBillingDiscount extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysqlu')->hasTable('billing_discount')) {
            Schema::connection('mysqlu')->create('billing_discount', function (Blueprint $table) {
                $table->string('name');
                $table->increments('id');
                $table->float('amount');
                $table->float('percent');
                $table->integer('currency_id')->unsigned()->nullable()->index('billing_discount_currency_id_foreign');
            });
        } else {
            Schema::connection('mysqlu')->table('billing_discount', function (Blueprint $table) {
                if (!Schema::connection('mysqlu')->hasColumn('billing_discount', 'name')) {
                    $table->string('name');
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_discount', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_discount', 'amount')) {
                    $table->float('amount');
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_discount', 'percent')) {
                    $table->float('percent');
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_discount', 'currency_id')) {
                    $table->integer('currency_id')->unsigned()->nullable()->index('billing_discount_currency_id_foreign');
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
        Schema::connection('mysqlu')->drop('billing_discount');
    }

}