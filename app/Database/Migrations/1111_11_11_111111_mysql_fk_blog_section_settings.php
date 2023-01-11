<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkBlogSectionSettings extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('blog_section_settings', function (Blueprint $table) {
            if (!Utils::hasForeignKey('blog_section_settings', 'blog_section_settings_section_id_foreign', 'mysql')) {
                $table->foreign('section_id')->references('id')->on('blog_section')
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
        Schema::connection('mysql')->table('blog_section_settings', function (Blueprint $table) {
            $table->dropForeign('blog_section_settings_section_id_foreign');
        });
    }

}
