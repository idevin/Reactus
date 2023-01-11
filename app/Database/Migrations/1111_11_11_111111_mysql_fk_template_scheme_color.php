<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkTemplateSchemeColor extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('template_scheme_color', function (Blueprint $table) {
            if (!Utils::hasForeignKey('template_scheme_color', 'template_scheme_color_template_scheme_id_foreign', 'mysql')) {
                $table->foreign('template_scheme_id')->references('id')->on('template_scheme')
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
        Schema::connection('mysql')->table('template_scheme_color', function (Blueprint $table) {
            $table->dropForeign('template_scheme_color_template_scheme_id_foreign');
        });
    }

}
