<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkStorageFileTag extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('storage_file_tag', function (Blueprint $table) {
            if (!Utils::hasForeignKey('storage_file_tag', 'storage_file_tag_storage_file_id_foreign', 'mysql')) {
                $table->foreign('storage_file_id')->references('id')->on('storage_file')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('storage_file_tag', 'storage_file_tag_storage_tag_id_foreign', 'mysql')) {
                $table->foreign('storage_tag_id')->references('id')->on('storage_tag')
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
        Schema::connection('mysql')->table('storage_file_tag', function (Blueprint $table) {
            $table->dropForeign('storage_file_tag_storage_file_id_foreign');
            $table->dropForeign('storage_file_tag_storage_tag_id_foreign');
        });
    }

}
