<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkFieldUserGroup extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('field_user_group', function (Blueprint $table) {
            if (!Utils::hasForeignKey('field_user_group', 'field_user_group_field_group_id_foreign', 'mysql')) {
                $table->foreign('field_group_id')->references('id')->on('field_group')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('field_user_group', 'field_user_group_user_id_foreign', 'mysql')) {
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
        Schema::connection('mysql')->table('field_user_group', function (Blueprint $table) {
            $table->dropForeign('field_user_group_field_group_id_foreign');
            $table->dropForeign('field_user_group_user_id_foreign');
        });
    }

}
