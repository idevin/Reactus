<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqluFkFeedbackLogField extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysqlu')->table('feedback_log_field', function (Blueprint $table) {
            if (!Utils::hasForeignKey('feedback_log_field', 'feedback_log_field_feedback_log_id_foreign', 'mysqlu')) {
                $table->foreign('feedback_log_id')->references('id')->on('feedback_log')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('feedback_log_field', 'feedback_log_field_field_id_foreign', 'mysqlu')) {
                $table->foreign('field_id')->references('id')->on(env('DB_DATABASE') . '.' . 'field')
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
        Schema::connection('mysqlu')->table('feedback_log_field', function (Blueprint $table) {
            $table->dropForeign('feedback_log_field_feedback_log_id_foreign');
            $table->dropForeign('feedback_log_field_field_id_foreign');
        });
    }

}
