<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkModuleLogo extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('module_logo', function (Blueprint $table) {
            if (!Utils::hasForeignKey('module_logo', 'module_logo_site_id_foreign', 'mysql')) {
                $table->foreign('site_id')->references('id')->on('site')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('module_logo', 'module_logo_storage_file_id_foreign', 'mysql')) {
                $table->foreign('storage_file_id')->references('id')->on('storage_file')
                    ->onUpdate('NO ACTION')->onDelete('SET NULL');
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
        Schema::connection('mysql')->table('module_logo', function (Blueprint $table) {
            $table->dropForeign('module_logo_site_id_foreign');
            $table->dropForeign('module_logo_storage_file_id_foreign');
        });
    }

}
