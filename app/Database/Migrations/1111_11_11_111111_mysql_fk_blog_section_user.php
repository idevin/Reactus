<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkBlogSectionUser extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('blog_section_user', function (Blueprint $table) {
            if (!Utils::hasForeignKey('blog_section_user', 'blog_section_user_section_id_foreign', 'mysql')) {
                $table->foreign('section_id')->references('id')->on('blog_section')
                    ->onUpdate('NO ACTION')->onDelete('NO ACTION');
            }
            if (!Utils::hasForeignKey('blog_section_user', 'blog_section_user_user_id_foreign', 'mysql')) {
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
        Schema::connection('mysql')->table('blog_section_user', function (Blueprint $table) {
            $table->dropForeign('blog_section_user_section_id_foreign');
            $table->dropForeign('blog_section_user_user_id_foreign');
        });
    }

}
