<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqluCreateBillingServiceOptions extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysqlu')->hasTable('billing_service_options')) {
            Schema::connection('mysqlu')->create('billing_service_options', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('billing_service_id')->unsigned()->nullable()->index('billing_service_options_billing_service_id_foreign');
                $table->string('name');
                $table->string('increment_type')->nullable();
                $table->float('price')->default("0.00");
            });
        } else {
            Schema::connection('mysqlu')->table('billing_service_options', function (Blueprint $table) {
                if (!Schema::connection('mysqlu')->hasColumn('billing_service_options', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_service_options', 'billing_service_id')) {
                    $table->integer('billing_service_id')->unsigned()->nullable()->index('billing_service_options_billing_service_id_foreign');
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_service_options', 'name')) {
                    $table->string('name');
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_service_options', 'increment_type')) {
                    $table->string('increment_type')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_service_options', 'price')) {
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
        Schema::connection('mysqlu')->drop('billing_service_options');
    }

}