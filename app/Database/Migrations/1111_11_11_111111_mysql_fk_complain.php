<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkComplain extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('complain', function (Blueprint $table) {
            if (!Utils::hasForeignKey('complain', 'complain_complain_option_id_foreign', 'mysql')) {
                $table->foreign('complain_option_id')->references('id')->on('complain_option')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('complain', 'complain_moderator_id_foreign', 'mysql')) {
                $table->foreign('moderator_id')->references('id')->on(env('DBU_DATABASE') . '.' . 'user')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('complain', 'complain_on_user_id_foreign', 'mysql')) {
                $table->foreign('on_user_id')->references('id')->on(env('DBU_DATABASE') . '.' . 'user')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('complain', 'complain_user_id_foreign', 'mysql')) {
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
        Schema::connection('mysql')->table('complain', function (Blueprint $table) {
            $table->dropForeign('complain_complain_option_id_foreign');
            $table->dropForeign('complain_moderator_id_foreign');
            $table->dropForeign('complain_on_user_id_foreign');
            $table->dropForeign('complain_user_id_foreign');
        });
    }

}
