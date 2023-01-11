<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkModuleSlider extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('module_slider', function (Blueprint $table) {
            if (!Utils::hasForeignKey('module_slider', 'module_slider_site_id_foreign', 'mysql')) {
                $table->foreign('site_id')->references('id')->on('site')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('module_slider', 'module_slider_module_id_foreign', 'mysql')) {
                $table->foreign('module_id')->references('id')->on('module')
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
        Schema::connection('mysql')->table('module_slider', function (Blueprint $table) {
            $table->dropForeign('module_slider_site_id_foreign');
            $table->dropForeign('module_slider_module_id_foreign');
        });
    }

}
