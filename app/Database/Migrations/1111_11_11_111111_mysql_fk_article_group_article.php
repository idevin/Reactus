<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkArticleGroupArticle extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('article_group_article', function (Blueprint $table) {
            if (!Utils::hasForeignKey('article_group_article', 'article_group_article_article_group_id_foreign', 'mysql')) {
                $table->foreign('article_group_id')->references('id')->on('article_group')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('article_group_article', 'article_group_article_article_id_foreign', 'mysql')) {
                $table->foreign('article_id')->references('id')->on('article')
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
        Schema::connection('mysql')->table('article_group_article', function (Blueprint $table) {
            $table->dropForeign('article_group_article_article_group_id_foreign');
            $table->dropForeign('article_group_article_article_id_foreign');
        });
    }

}
