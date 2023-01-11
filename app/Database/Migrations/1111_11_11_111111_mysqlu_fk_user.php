<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqluFkUser extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysqlu')->table('user', function (Blueprint $table) {
            if (!Utils::hasForeignKey('user', 'user_language_id_foreign', 'mysqlu')) {
                $table->foreign('language_id')->references('id')->on(env('DB_DATABASE') . '.' . 'language')
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
        Schema::connection('mysqlu')->table('user', function (Blueprint $table) {
            $table->dropForeign('user_language_id_foreign');
        });
    }

}
