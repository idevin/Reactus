<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkFeedbackRecipient extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('feedback_recipient', function (Blueprint $table) {
            if (!Utils::hasForeignKey('feedback_recipient', 'feedback_recipient_site_id_foreign', 'mysql')) {
                $table->foreign('site_id')->references('id')->on('site')
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
        Schema::connection('mysql')->table('feedback_recipient', function (Blueprint $table) {
            $table->dropForeign('feedback_recipient_site_id_foreign');
        });
    }

}
