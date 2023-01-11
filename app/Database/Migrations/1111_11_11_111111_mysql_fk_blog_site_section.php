<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkBlogSiteSection extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('blog_site_section', function (Blueprint $table) {
            if (!Utils::hasForeignKey('blog_site_section', 'blog_site_section_section_id_foreign', 'mysql')) {
                $table->foreign('section_id')->references('id')->on('section')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('blog_site_section', 'blog_site_section_site_id_foreign', 'mysql')) {
                $table->foreign('site_id')->references('id')->on('blog_site')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('blog_site_section', 'blog_site_section_template_id_foreign', 'mysql')) {
                $table->foreign('template_id')->references('id')->on('template')
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
        Schema::connection('mysql')->table('blog_site_section', function (Blueprint $table) {
            $table->dropForeign('blog_site_section_section_id_foreign');
            $table->dropForeign('blog_site_section_site_id_foreign');
            $table->dropForeign('blog_site_section_template_id_foreign');
        });
    }

}
