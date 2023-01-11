<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkBlogComment extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('blog_comment', function (Blueprint $table) {
            if (!Utils::hasForeignKey('blog_comment', 'blog_comment_author_id_foreign', 'mysql')) {
                $table->foreign('author_id')->references('id')->on(env('DBU_DATABASE') . '.' . 'user')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('blog_comment', 'blog_comment_moderator_id_foreign', 'mysql')) {
                $table->foreign('moderator_id')->references('id')->on(env('DBU_DATABASE') . '.' . 'user')
                    ->onUpdate('NO ACTION')->onDelete('SET NULL');
            }
            if (!Utils::hasForeignKey('blog_comment', 'blog_comment_site_id_foreign', 'mysql')) {
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
        Schema::connection('mysql')->table('blog_comment', function (Blueprint $table) {
            $table->dropForeign('blog_comment_author_id_foreign');
            $table->dropForeign('blog_comment_moderator_id_foreign');
            $table->dropForeign('blog_comment_site_id_foreign');
        });
    }

}
