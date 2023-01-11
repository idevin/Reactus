<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkDomainMirror extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('domain_mirror', function (Blueprint $table) {
            if (!Utils::hasForeignKey('domain_mirror', 'domain_mirror_domain_id_foreign', 'mysql')) {
                $table->foreign('domain_id')->references('id')->on('domain')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('domain_mirror', 'domain_mirror_domain_mirror_id_foreign', 'mysql')) {
                $table->foreign('domain_mirror_id')->references('id')->on('domain')
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
        Schema::connection('mysql')->table('domain_mirror', function (Blueprint $table) {
            $table->dropForeign('domain_mirror_domain_id_foreign');
            $table->dropForeign('domain_mirror_domain_mirror_id_foreign');
        });
    }

}
