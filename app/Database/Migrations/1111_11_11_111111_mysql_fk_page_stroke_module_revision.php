<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkPageStrokeModuleRevision extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('page_stroke_module_revision', function (Blueprint $table) {
            if (!Utils::hasForeignKey('page_stroke_module_revision', 'page_stroke_module_revision_page_stroke_id_foreign', 'mysql')) {
                $table->foreign('page_stroke_id')->references('id')->on('page_stroke_revision')
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
        Schema::connection('mysql')->table('page_stroke_module_revision', function (Blueprint $table) {
            $table->dropForeign('page_stroke_module_revision_page_stroke_id_foreign');
        });
    }

}
