<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkSiteSection extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('site_section', function (Blueprint $table) {
            if (!Utils::hasForeignKey('site_section', 'site_section_site_id_foreign', 'mysql')) {
                $table->foreign('site_id')->references('id')->on('site')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('site_section', 'site_section_template_id_foreign', 'mysql')) {
                $table->foreign('template_id')->references('id')->on('template')
                    ->onUpdate('NO ACTION')->onDelete('NO ACTION');
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
        Schema::connection('mysql')->table('site_section', function (Blueprint $table) {
            $table->dropForeign('site_section_site_id_foreign');
            $table->dropForeign('site_section_template_id_foreign');
        });
    }

}
