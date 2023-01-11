<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkBlogArticleRevision extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('blog_article_revision', function (Blueprint $table) {
            if (!Utils::hasForeignKey('blog_article_revision', 'blog_article_revision_article_id_foreign', 'mysql')) {
                $table->foreign('article_id')->references('id')->on('blog_article')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('blog_article_revision', 'blog_article_revision_author_id_foreign', 'mysql')) {
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
        Schema::connection('mysql')->table('blog_article_revision', function (Blueprint $table) {
            $table->dropForeign('blog_article_revision_article_id_foreign');
            $table->dropForeign('blog_article_revision_author_id_foreign');
        });
    }

}
