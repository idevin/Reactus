<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqluFkUserStatus extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysqlu')->table('user_status', function (Blueprint $table) {
            if (!Utils::hasForeignKey('user_status', 'user_status_user_id_foreign', 'mysqlu')) {
                $table->foreign('user_id')->references('id')->on(env('DBU_DATABASE') . '.' . 'user')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('user_status', 'user_status_user_status_emotion_id_foreign', 'mysqlu')) {
                $table->foreign('user_status_emotion_id')->references('id')->on('user_status_emotion')
                    ->onUpdate('NO ACTION')->onDelete('SET NULL');
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
        Schema::connection('mysqlu')->table('user_status', function (Blueprint $table) {
            $table->dropForeign('user_status_user_id_foreign');
            $table->dropForeign('user_status_user_status_emotion_id_foreign');
        });
    }

}
