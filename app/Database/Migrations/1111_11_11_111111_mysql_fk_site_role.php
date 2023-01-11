<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkSiteRole extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('site_role', function (Blueprint $table) {
            if (!Utils::hasForeignKey('site_role', 'site_role_role_id_foreign', 'mysql')) {
                $table->foreign('role_id')->references('id')->on(env('DBU_DATABASE') . '.' . 'role')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('site_role', 'site_role_site_id_foreign', 'mysql')) {
                $table->foreign('site_id')->references('id')->on('site')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('site_role', 'site_role_user_id_foreign', 'mysql')) {
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
        Schema::connection('mysql')->table('site_role', function (Blueprint $table) {
            $table->dropForeign('site_role_role_id_foreign');
            $table->dropForeign('site_role_site_id_foreign');
            $table->dropForeign('site_role_user_id_foreign');
        });
    }

}
