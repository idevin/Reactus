<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkBlogArticle extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('blog_article', function (Blueprint $table) {
            if (!Utils::hasForeignKey('blog_article', 'blog_article_author_id_foreign', 'mysql')) {
                $table->foreign('author_id')->references('id')->on(env('DBU_DATABASE') . '.' . 'user')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('blog_article', 'blog_article_last_comment_id_foreign', 'mysql')) {
                $table->foreign('last_comment_id')->references('id')->on('blog_comment')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('blog_article', 'blog_article_section_id_foreign', 'mysql')) {
                $table->foreign('section_id')->references('id')->on('blog_section')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('blog_article', 'blog_article_site_id_foreign', 'mysql')) {
                $table->foreign('site_id')->references('id')->on('blog_site')
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
        Schema::connection('mysql')->table('blog_article', function (Blueprint $table) {
            $table->dropForeign('blog_article_author_id_foreign');
            $table->dropForeign('blog_article_last_comment_id_foreign');
            $table->dropForeign('blog_article_section_id_foreign');
            $table->dropForeign('blog_article_site_id_foreign');
        });
    }

}
