<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkTemplateToTemplateScheme extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('template_to_template_scheme', function (Blueprint $table) {
            if (!Utils::hasForeignKey('template_to_template_scheme', 'template_to_template_scheme_template_id_foreign', 'mysql')) {
                $table->foreign('template_id')->references('id')->on('template')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('template_to_template_scheme', 'template_to_template_scheme_template_scheme_id_foreign', 'mysql')) {
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
        Schema::connection('mysql')->table('template_to_template_scheme', function (Blueprint $table) {
            $table->dropForeign('template_to_template_scheme_template_id_foreign');
            $table->dropForeign('template_to_template_scheme_template_scheme_id_foreign');
        });
    }

}
