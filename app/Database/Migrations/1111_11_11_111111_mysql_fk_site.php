<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkSite extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('site', function (Blueprint $table) {
            if (!Utils::hasForeignKey('site', 'site_domain_id_foreign', 'mysql')) {
                $table->foreign('domain_id')->references('id')->on('domain')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('site', 'site_template_scheme_id_foreign', 'mysql')) {
                $table->foreign('template_scheme_id')->references('id')->on('template_scheme')
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
        Schema::connection('mysql')->table('site', function (Blueprint $table) {
            $table->dropForeign('site_domain_id_foreign');
            $table->dropForeign('site_template_scheme_id_foreign');
        });
    }

}
