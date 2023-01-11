<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqluCreateBillingServiceToRole extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysqlu')->hasTable('billing_service_to_role')) {
            Schema::connection('mysqlu')->create('billing_service_to_role', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('role_id')->unsigned()->index('billing_service_to_role_role_id_foreign');
                $table->integer('billing_service_id')->unsigned()->index('billing_service_to_role_billing_service_id_foreign');
            });
        } else {
            Schema::connection('mysqlu')->table('billing_service_to_role', function (Blueprint $table) {
                if (!Schema::connection('mysqlu')->hasColumn('billing_service_to_role', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_service_to_role', 'role_id')) {
                    $table->integer('role_id')->unsigned()->index('billing_service_to_role_role_id_foreign');
                }
                if (!Schema::connection('mysqlu')->hasColumn('billing_service_to_role', 'billing_service_id')) {
                    $table->integer('billing_service_id')->unsigned()->index('billing_service_to_role_billing_service_id_foreign');
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
        Schema::connection('mysqlu')->drop('billing_service_to_role');
    }

}