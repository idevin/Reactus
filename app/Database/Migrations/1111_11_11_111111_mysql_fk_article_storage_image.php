<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkArticleStorageImage extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('article_storage_image', function (Blueprint $table) {
            if (!Utils::hasForeignKey('article_storage_image', 'article_storage_image_article_id_foreign', 'mysql')) {
                $table->foreign('article_id')->references('id')->on('article')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('article_storage_image', 'article_storage_image_storage_file_id_foreign', 'mysql')) {
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
        Schema::connection('mysql')->table('article_storage_image', function (Blueprint $table) {
            $table->dropForeign('article_storage_image_article_id_foreign');
            $table->dropForeign('article_storage_image_storage_file_id_foreign');
        });
    }

}
