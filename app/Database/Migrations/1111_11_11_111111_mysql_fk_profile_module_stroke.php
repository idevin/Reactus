<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkProfileModuleStroke extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('profile_module_stroke', function (Blueprint $table) {
            if (!Utils::hasForeignKey('profile_module_stroke', 'profile_module_stroke_site_id_foreign', 'mysql')) {
                $table->foreign('site_id')->references('id')->on('site')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('profile_module_stroke', 'profile_module_stroke_user_id_foreign', 'mysql')) {
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
        Schema::connection('mysql')->table('profile_module_stroke', function (Blueprint $table) {
            $table->dropForeign('profile_module_stroke_site_id_foreign');
            $table->dropForeign('profile_module_stroke_user_id_foreign');
        });
    }

}
