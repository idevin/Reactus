<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkPageStroke extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('page_stroke', function (Blueprint $table) {
            if (!Utils::hasForeignKey('page_stroke', 'page_stroke_page_id_foreign', 'mysql')) {
                $table->foreign('page_id')->references('id')->on('page')
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
        Schema::connection('mysql')->table('page_stroke', function (Blueprint $table) {
            $table->dropForeign('page_stroke_page_id_foreign');
        });
    }

}
