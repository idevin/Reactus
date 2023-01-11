<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqluFkBillingServiceOptions extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysqlu')->table('billing_service_options', function (Blueprint $table) {
            if (!Utils::hasForeignKey('billing_service_options', 'billing_service_options_billing_service_id_foreign', 'mysqlu')) {
                $table->foreign('billing_service_id')->references('id')->on('billing_service')
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
        Schema::connection('mysqlu')->table('billing_service_options', function (Blueprint $table) {
            $table->dropForeign('billing_service_options_billing_service_id_foreign');
        });
    }

}
