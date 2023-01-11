<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkModerationAnswer extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('moderation_answer', function (Blueprint $table) {
            if (!Utils::hasForeignKey('moderation_answer', 'moderation_answer_author_id_foreign', 'mysql')) {
                $table->foreign('author_id')->references('id')->on(env('DBU_DATABASE') . '.' . 'user')
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
        Schema::connection('mysql')->table('moderation_answer', function (Blueprint $table) {
            $table->dropForeign('moderation_answer_author_id_foreign');
        });
    }

}
