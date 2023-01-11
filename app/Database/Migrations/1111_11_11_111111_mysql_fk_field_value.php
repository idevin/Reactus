<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkFieldValue extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('field_value', function (Blueprint $table) {
            if (!Utils::hasForeignKey('field_value', 'field_value_field_id_foreign', 'mysql')) {
                $table->foreign('field_id')->references('id')->on('field')
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
        Schema::connection('mysql')->table('field_value', function (Blueprint $table) {
            $table->dropForeign('field_value_field_id_foreign');
        });
    }

}
