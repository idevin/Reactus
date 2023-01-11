<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkLanguageObjectGroup extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('language_object_group', function (Blueprint $table) {
            if (!Utils::hasForeignKey('language_object_group', 'language_object_group_language_id_foreign', 'mysql')) {
                $table->foreign('language_id')->references('id')->on('language')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('language_object_group', 'language_object_group_language_object_id_foreign', 'mysql')) {
                $table->foreign('language_object_id')->references('id')->on('language_object')
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
        Schema::connection('mysql')->table('language_object_group', function (Blueprint $table) {
            $table->dropForeign('language_object_group_language_id_foreign');
            $table->dropForeign('language_object_group_language_object_id_foreign');
        });
    }

}
