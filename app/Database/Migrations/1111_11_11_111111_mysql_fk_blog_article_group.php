<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkBlogArticleGroup extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('blog_article_group', function (Blueprint $table) {
            if (!Utils::hasForeignKey('blog_article_group', 'blog_article_group_article_id_foreign', 'mysql')) {
                $table->foreign('article_id')->references('id')->on('blog_article')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('blog_article_group', 'blog_article_group_site_id_foreign', 'mysql')) {
                $table->foreign('site_id')->references('id')->on('blog_site')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('blog_article_group', 'blog_article_group_user_id_foreign', 'mysql')) {
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
        Schema::connection('mysql')->table('blog_article_group', function (Blueprint $table) {
            $table->dropForeign('blog_article_group_article_id_foreign');
            $table->dropForeign('blog_article_group_site_id_foreign');
            $table->dropForeign('blog_article_group_user_id_foreign');
        });
    }

}
