<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkBlogSection extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('blog_section', function (Blueprint $table) {
            if (!Utils::hasForeignKey('blog_section', 'blog_section_last_article_id_foreign', 'mysql')) {
                $table->foreign('last_article_id')->references('id')->on('blog_article')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('blog_section', 'blog_section_last_comment_id_foreign', 'mysql')) {
                $table->foreign('last_comment_id')->references('id')->on('blog_comment')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('blog_section', 'blog_section_site_id_foreign', 'mysql')) {
                $table->foreign('site_id')->references('id')->on('blog_site')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('blog_section', 'blog_section_user_id_foreign', 'mysql')) {
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
        Schema::connection('mysql')->table('blog_section', function (Blueprint $table) {
            $table->dropForeign('blog_section_last_article_id_foreign');
            $table->dropForeign('blog_section_last_comment_id_foreign');
            $table->dropForeign('blog_section_site_id_foreign');
            $table->dropForeign('blog_section_user_id_foreign');
        });
    }

}
