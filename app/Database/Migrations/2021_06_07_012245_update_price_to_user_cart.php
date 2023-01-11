<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePriceToUserCart extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysqlu')->table('user_cart', function (Blueprint $table) {
            $table->increments('id')->after('user_id');
            $table->bigInteger('user_id')->unsigned()->after('id')->change();
            $table->decimal('price')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysqlu')->table('user_cart', function (Blueprint $table) {
            $table->integer('price')->change();
        });
    }
}
