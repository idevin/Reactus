<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqluFkUserSite extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysqlu')->table('user_site', function (Blueprint $table) {
            if (!Utils::hasForeignKey('user_site', 'user_site_site_id_foreign', 'mysqlu')) {
                $table->foreign('site_id')->references('id')->on(env('DB_DATABASE') . '.' . 'site')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('user_site', 'user_site_user_id_foreign', 'mysqlu')) {
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
        Schema::connection('mysqlu')->table('user_site', function (Blueprint $table) {
            $table->dropForeign('user_site_site_id_foreign');
            $table->dropForeign('user_site_user_id_foreign');
        });
    }

}
