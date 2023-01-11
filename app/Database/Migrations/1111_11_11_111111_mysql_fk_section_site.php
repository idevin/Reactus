<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkSectionSite extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('section_site', function (Blueprint $table) {
            if (!Utils::hasForeignKey('section_site', 'section_site_from_site_id_foreign', 'mysql')) {
                $table->foreign('from_site_id')->references('id')->on('site')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('section_site', 'section_site_section_id_foreign', 'mysql')) {
                $table->foreign('section_id')->references('id')->on('section')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('section_site', 'section_site_site_id_foreign', 'mysql')) {
                $table->foreign('site_id')->references('id')->on('site')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('section_site', 'section_site_to_section_id_foreign', 'mysql')) {
                $table->foreign('to_section_id')->references('id')->on('section')
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
        Schema::connection('mysql')->table('section_site', function (Blueprint $table) {
            $table->dropForeign('section_site_from_site_id_foreign');
            $table->dropForeign('section_site_section_id_foreign');
            $table->dropForeign('section_site_site_id_foreign');
            $table->dropForeign('section_site_to_section_id_foreign');
        });
    }

}
