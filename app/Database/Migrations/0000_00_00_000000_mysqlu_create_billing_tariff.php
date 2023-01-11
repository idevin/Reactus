<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqluCreateBillingTariff extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysqlu')->hasTable('billing_tariff')) {
            Schema::connection('mysqlu')->create('billing_tariff', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->text('description');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->dateTime('end_date')->nullable();
            });
        } else {
            Schema::connection('mysqlu')->table('billing_tariff', function (Blueprint $table) {
                if (!Schema::connection('mysqlu')->hasColumn('billing_tariff', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_tariff', 'name')) {
                    $table->string('name');
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_tariff', 'description')) {
                    $table->text('description');
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_tariff', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_tariff', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_tariff', 'end_date')) {
                    $table->dateTime('end_date')->nullable();
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
        Schema::connection('mysqlu')->drop('billing_tariff');
    }

}