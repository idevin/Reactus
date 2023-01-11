<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqluFkUserOrder extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysqlu')->table('user_order', function (Blueprint $table) {
            if (!Utils::hasForeignKey('user_order', 'user_order_billing_discount_id_foreign', 'mysqlu')) {
                $table->foreign('billing_discount_id')->references('id')->on('billing_discount')
                    ->onUpdate('NO ACTION')->onDelete('SET NULL');
            }
            if (!Utils::hasForeignKey('user_order', 'user_order_site_id_foreign', 'mysqlu')) {
                $table->foreign('site_id')->references('id')->on(env('DB_DATABASE') . '.' . 'site')
                    ->onUpdate('NO ACTION')->onDelete('SET NULL');
            }
            if (!Utils::hasForeignKey('user_order', 'user_order_user_id_foreign', 'mysqlu')) {
                $table->foreign('user_id')->references('id')->on(env('DBU_DATABASE') . '.' . 'user')
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
        Schema::connection('mysqlu')->table('user_order', function (Blueprint $table) {
            $table->dropForeign('user_order_billing_discount_id_foreign');
            $table->dropForeign('user_order_site_id_foreign');
            $table->dropForeign('user_order_user_id_foreign');
        });
    }

}
