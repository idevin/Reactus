<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqluFkFeedbackLog extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysqlu')->table('feedback_log', function (Blueprint $table) {
            if (!Utils::hasForeignKey('feedback_log', 'feedback_log_from_user_id_foreign', 'mysqlu')) {
                $table->foreign('from_user_id')->references('id')->on(env('DBU_DATABASE') . '.' . 'user')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('feedback_log', 'feedback_log_site_id_foreign', 'mysqlu')) {
                $table->foreign('site_id')->references('id')->on(env('DB_DATABASE') . '.' . 'site')
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
        Schema::connection('mysqlu')->table('feedback_log', function (Blueprint $table) {
            $table->dropForeign('feedback_log_from_user_id_foreign');
            $table->dropForeign('feedback_log_site_id_foreign');
        });
    }

}
