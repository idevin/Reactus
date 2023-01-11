<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkModuleCompetitiveAdvantagesItems extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('module_competitive_advantages_items', function (Blueprint $table) {
            if (!Utils::hasForeignKey('module_competitive_advantages_items', 'module_competitive_advantages_items_advantages_id_foreign', 'mysql')) {
                $table->foreign('advantages_id')->references('id')->on('module_competitive_advantages')
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
        Schema::connection('mysql')->table('module_competitive_advantages_items', function (Blueprint $table) {
            $table->dropForeign('module_competitive_advantages_items_advantages_id_foreign');
        });
    }

}
