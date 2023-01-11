<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkBlogSite extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('blog_site', function (Blueprint $table) {
            if (!Utils::hasForeignKey('blog_site', 'blog_site_domain_id_foreign', 'mysql')) {
                $table->foreign('domain_id')->references('id')->on('domain')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('blog_site', 'blog_site_domain_volume_id_foreign', 'mysql')) {
                $table->foreign('domain_volume_id')->references('id')->on('domain_volume')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('blog_site', 'blog_site_user_id_foreign', 'mysql')) {
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
        Schema::connection('mysql')->table('blog_site', function (Blueprint $table) {
            $table->dropForeign('blog_site_domain_id_foreign');
            $table->dropForeign('blog_site_domain_volume_id_foreign');
            $table->dropForeign('blog_site_user_id_foreign');
        });
    }

}
