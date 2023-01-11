<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkPageStrokeModule extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('page_stroke_module', function (Blueprint $table) {
            if (!Utils::hasForeignKey('page_stroke_module', 'page_stroke_module_page_stroke_id_foreign', 'mysql')) {
                $table->foreign('page_stroke_id')->references('id')->on('page_stroke')
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
        Schema::connection('mysql')->table('page_stroke_module', function (Blueprint $table) {
            $table->dropForeign('page_stroke_module_page_stroke_id_foreign');
        });
    }

}
