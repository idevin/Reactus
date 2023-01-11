<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkField extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('field', function (Blueprint $table) {
            if (!Utils::hasForeignKey('field', 'field_field_group_id_foreign', 'mysql')) {
                $table->foreign('field_group_id')->references('id')->on('field_group')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('field', 'field_site_id_foreign', 'mysql')) {
                $table->foreign('site_id')->references('id')->on('site')
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
        Schema::connection('mysql')->table('field', function (Blueprint $table) {
            $table->dropForeign('field_field_group_id_foreign');
            $table->dropForeign('field_site_id_foreign');
        });
    }

}
