<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkOrderStatusToOrder extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('order_status_to_order', function (Blueprint $table) {
            if (!Utils::hasForeignKey('order_status_to_order', 'order_status_to_order_order_id_foreign', 'mysql')) {
                $table->foreign('order_id')->references('id')->on('orders')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('order_status_to_order', 'order_status_to_order_status_id_foreign', 'mysql')) {
                $table->foreign('status_id')->references('id')->on('order_status')
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
        Schema::connection('mysql')->table('order_status_to_order', function (Blueprint $table) {
            $table->dropForeign('order_status_to_order_order_id_foreign');
            $table->dropForeign('order_status_to_order_status_id_foreign');
        });
    }

}
