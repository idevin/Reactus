<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkFeedback extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('feedback', function (Blueprint $table) {
            if (!Utils::hasForeignKey('feedback', 'feedback_field_id_foreign', 'mysql')) {
                $table->foreign('field_id')->references('id')->on('field')
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
        Schema::connection('mysql')->table('feedback', function (Blueprint $table) {
            $table->dropForeign('feedback_field_id_foreign');
        });
    }

}
