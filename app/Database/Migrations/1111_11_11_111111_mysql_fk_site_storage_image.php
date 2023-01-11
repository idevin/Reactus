<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkSiteStorageImage extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('site_storage_image', function (Blueprint $table) {
            if (!Utils::hasForeignKey('site_storage_image', 'site_storage_image_site_id_foreign', 'mysql')) {
                $table->foreign('site_id')->references('id')->on('site')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('site_storage_image', 'site_storage_image_storage_file_id_foreign', 'mysql')) {
                $table->foreign('storage_file_id')->references('id')->on('storage_file')
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
        Schema::connection('mysql')->table('site_storage_image', function (Blueprint $table) {
            $table->dropForeign('site_storage_image_site_id_foreign');
            $table->dropForeign('site_storage_image_storage_file_id_foreign');
        });
    }

}
