<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkProfileModuleStrokeCell extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('profile_module_stroke_cell', function (Blueprint $table) {
            if (!Utils::hasForeignKey('profile_module_stroke_cell', 'profile_module_stroke_cell_profile_module_id_foreign', 'mysql')) {
                $table->foreign('profile_module_id')->references('id')->on('profile_module')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('profile_module_stroke_cell', 'profile_module_stroke_cell_profile_module_stroke_id_foreign', 'mysql')) {
                $table->foreign('profile_module_stroke_id')->references('id')->on('profile_module_stroke')
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
        Schema::connection('mysql')->table('profile_module_stroke_cell', function (Blueprint $table) {
            $table->dropForeign('profile_module_stroke_cell_profile_module_id_foreign');
            $table->dropForeign('profile_module_stroke_cell_profile_module_stroke_id_foreign');
        });
    }

}
