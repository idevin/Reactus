<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkObjectField extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('object_field', function (Blueprint $table) {
            if (!Utils::hasForeignKey('object_field', 'object_field_object_field_group_id_foreign', 'mysql')) {
                $table->foreign('object_field_group_id')->references('id')->on('object_field_group')
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
        Schema::connection('mysql')->table('object_field', function (Blueprint $table) {
            $table->dropForeign('object_field_object_field_group_id_foreign');
        });
    }

}
