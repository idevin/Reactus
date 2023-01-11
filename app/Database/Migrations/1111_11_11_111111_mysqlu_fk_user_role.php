<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqluFkUserRole extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysqlu')->table('user_role', function (Blueprint $table) {
            if (!Utils::hasForeignKey('user_role', 'user_role_role_id_foreign', 'mysqlu')) {
                $table->foreign('role_id')->references('id')->on('role')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('user_role', 'user_role_user_id_foreign', 'mysqlu')) {
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
        Schema::connection('mysqlu')->table('user_role', function (Blueprint $table) {
            $table->dropForeign('user_role_role_id_foreign');
            $table->dropForeign('user_role_user_id_foreign');
        });
    }

}
