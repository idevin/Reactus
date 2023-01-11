<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkModuleMenuAdvancedUrls extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('module_menu_advanced_urls', function (Blueprint $table) {
            if (!Utils::hasForeignKey('module_menu_advanced_urls', 'module_menu_advanced_urls_module_menu_advanced_id_foreign', 'mysql')) {
                $table->foreign('module_menu_advanced_id')->references('id')->on('module_menu_advanced')
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
        Schema::connection('mysql')->table('module_menu_advanced_urls', function (Blueprint $table) {
            $table->dropForeign('module_menu_advanced_urls_module_menu_advanced_id_foreign');
        });
    }

}
