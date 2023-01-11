<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkSectionSettings extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('section_settings', function (Blueprint $table) {
            if (!Utils::hasForeignKey('section_settings', 'section_settings_section_id_foreign', 'mysql')) {
                $table->foreign('section_id')->references('id')->on('section')
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
        Schema::connection('mysql')->table('section_settings', function (Blueprint $table) {
            $table->dropForeign('section_settings_section_id_foreign');
        });
    }

}
