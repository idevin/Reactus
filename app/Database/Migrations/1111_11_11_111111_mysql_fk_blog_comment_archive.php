<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkBlogCommentArchive extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('blog_comment_archive', function (Blueprint $table) {
            if (!Utils::hasForeignKey('blog_comment_archive', 'blog_comment_archive_article_id_foreign', 'mysql')) {
                $table->foreign('article_id')->references('id')->on('blog_article')
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
        Schema::connection('mysql')->table('blog_comment_archive', function (Blueprint $table) {
            $table->dropForeign('blog_comment_archive_article_id_foreign');
        });
    }

}
