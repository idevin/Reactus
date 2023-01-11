<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkModuleArticle extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('module_article', function (Blueprint $table) {
            if (!Utils::hasForeignKey('module_article', 'module_article_module_id_foreign', 'mysql')) {
                $table->foreign('module_id')->references('id')->on('module')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('module_article', 'module_article_section_id_foreign', 'mysql')) {
                $table->foreign('section_id')->references('id')->on('section')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('module_article', 'module_article_site_id_foreign', 'mysql')) {
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
        Schema::connection('mysql')->table('module_article', function (Blueprint $table) {
            $table->dropForeign('module_article_module_id_foreign');
            $table->dropForeign('module_article_section_id_foreign');
            $table->dropForeign('module_article_site_id_foreign');
        });
    }

}
