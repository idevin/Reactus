<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqluFkUserPermission extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysqlu')->table('user_permission', function (Blueprint $table) {
            if (!Utils::hasForeignKey('user_permission', 'user_permission_permission_id_foreign', 'mysqlu')) {
                $table->foreign('permission_id')->references('id')->on('permission')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('user_permission', 'user_permission_user_id_foreign', 'mysqlu')) {
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
        Schema::connection('mysqlu')->table('user_permission', function (Blueprint $table) {
            $table->dropForeign('user_permission_permission_id_foreign');
            $table->dropForeign('user_permission_user_id_foreign');
        });
    }

}
