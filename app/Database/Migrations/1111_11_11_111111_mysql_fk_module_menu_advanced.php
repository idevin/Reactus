<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkModuleMenuAdvanced extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('module_menu_advanced', function (Blueprint $table) {
            if (!Utils::hasForeignKey('module_menu_advanced', 'module_menu_advanced_site_id_foreign', 'mysql')) {
                $table->foreign('site_id')->references('id')->on('site')
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
        Schema::connection('mysql')->table('module_menu_advanced', function (Blueprint $table) {
            $table->dropForeign('module_menu_advanced_site_id_foreign');
        });
    }

}
