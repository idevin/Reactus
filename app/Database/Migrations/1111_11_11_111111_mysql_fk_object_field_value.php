<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkObjectFieldValue extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('object_field_value', function (Blueprint $table) {
            if (!Utils::hasForeignKey('object_field_value', 'object_field_value_object_field_id_foreign', 'mysql')) {
                $table->foreign('object_field_id')->references('id')->on('object_field')
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
        Schema::connection('mysql')->table('object_field_value', function (Blueprint $table) {
            $table->dropForeign('object_field_value_object_field_id_foreign');
        });
    }

}
