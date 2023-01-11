<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkModuleSlide extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('module_slide', function (Blueprint $table) {
            if (!Utils::hasForeignKey('module_slide', 'module_slide_article_id_foreign', 'mysql')) {
                $table->foreign('article_id')->references('id')->on('article')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('module_slide', 'module_slide_module_slider_id_foreign', 'mysql')) {
                $table->foreign('module_slider_id')->references('id')->on('module_slider')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('module_slide', 'module_slide_section_id_foreign', 'mysql')) {
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
        Schema::connection('mysql')->table('module_slide', function (Blueprint $table) {
            $table->dropForeign('module_slide_article_id_foreign');
            $table->dropForeign('module_slide_module_slider_id_foreign');
            $table->dropForeign('module_slide_section_id_foreign');
        });
    }

}
