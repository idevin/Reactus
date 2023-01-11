<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqluFkUserStorageImage extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysqlu')->table('user_storage_image', function (Blueprint $table) {
            if (!Utils::hasForeignKey('user_storage_image', 'user_storage_image_storage_file_id_foreign', 'mysqlu')) {
                $table->foreign('storage_file_id')->references('id')->on(env('DB_DATABASE') . '.' . 'storage_file')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('user_storage_image', 'user_storage_image_user_id_foreign', 'mysqlu')) {
                $table->foreign('user_id')->references('id')->on(env('DBU_DATABASE') . '.' . 'user')
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
        Schema::connection('mysqlu')->table('user_storage_image', function (Blueprint $table) {
            $table->dropForeign('user_storage_image_storage_file_id_foreign');
            $table->dropForeign('user_storage_image_user_id_foreign');
        });
    }

}
