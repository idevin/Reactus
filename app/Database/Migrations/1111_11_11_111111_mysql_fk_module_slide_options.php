<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkModuleSlideOptions extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('module_slide_options', function (Blueprint $table) {
            if (!Utils::hasForeignKey('module_slide_options', 'module_slide_options_module_slide_id_foreign', 'mysql')) {
                $table->foreign('module_slide_id')->references('id')->on('module_slide')
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
        Schema::connection('mysql')->table('module_slide_options', function (Blueprint $table) {
            $table->dropForeign('module_slide_options_module_slide_id_foreign');
        });
    }

}
