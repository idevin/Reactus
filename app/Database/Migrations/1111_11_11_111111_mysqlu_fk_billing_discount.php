<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqluFkBillingDiscount extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysqlu')->table('billing_discount', function (Blueprint $table) {
            if (!Utils::hasForeignKey('billing_discount', 'billing_discount_currency_id_foreign', 'mysqlu')) {
                $table->foreign('currency_id')->references('id')->on('currency')
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
        Schema::connection('mysqlu')->table('billing_discount', function (Blueprint $table) {
            $table->dropForeign('billing_discount_currency_id_foreign');
        });
    }

}
