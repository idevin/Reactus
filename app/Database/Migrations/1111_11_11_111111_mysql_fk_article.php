<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkArticle extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('article', function (Blueprint $table) {
            if (!Utils::hasForeignKey('article', 'article_author_id_foreign', 'mysql')) {
                $table->foreign('author_id')->references('id')->on(env('DBU_DATABASE') . '.' . 'user')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('article', 'article_section_id_foreign', 'mysql')) {
                $table->foreign('section_id')->references('id')->on('section')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('article', 'article_site_id_foreign', 'mysql')) {
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
        Schema::connection('mysql')->table('article', function (Blueprint $table) {
            $table->dropForeign('article_author_id_foreign');
            $table->dropForeign('article_section_id_foreign');
            $table->dropForeign('article_site_id_foreign');
        });
    }

}
