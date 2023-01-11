<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkSectionUser extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('section_user', function (Blueprint $table) {
            if (!Utils::hasForeignKey('section_user', 'section_user_section_id_foreign', 'mysql')) {
                $table->foreign('section_id')->references('id')->on('section')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('section_user', 'section_user_user_id_foreign', 'mysql')) {
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
        Schema::connection('mysql')->table('section_user', function (Blueprint $table) {
            $table->dropForeign('section_user_section_id_foreign');
            $table->dropForeign('section_user_user_id_foreign');
        });
    }

}
