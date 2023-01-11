<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkSubscribeUsers extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('subscribe_users', function (Blueprint $table) {
            if (!Utils::hasForeignKey('subscribe_users', 'subscribe_users_on_user_id_foreign', 'mysql')) {
                $table->foreign('on_user_id')->references('id')->on(env('DBU_DATABASE') . '.' . 'user')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('subscribe_users', 'subscribe_users_subscribed_user_id_foreign', 'mysql')) {
                $table->foreign('subscribed_user_id')->references('id')->on(env('DBU_DATABASE') . '.' . 'user')
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
        Schema::connection('mysql')->table('subscribe_users', function (Blueprint $table) {
            $table->dropForeign('subscribe_users_on_user_id_foreign');
            $table->dropForeign('subscribe_users_subscribed_user_id_foreign');
        });
    }

}
