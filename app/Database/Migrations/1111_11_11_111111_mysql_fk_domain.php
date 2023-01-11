<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MysqlFkDomain extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('domain', function (Blueprint $table) {
            if (!Utils::hasForeignKey('domain', 'domain_domain_thematic_id_foreign', 'mysql')) {
                $table->foreign('domain_thematic_id')->references('id')->on('domain_thematic')
                    ->onUpdate('CASCADE')->onDelete('SET NULL');
            }
            if (!Utils::hasForeignKey('domain', 'domain_domain_volume_id_foreign', 'mysql')) {
                $table->foreign('domain_volume_id')->references('id')->on('domain_volume')
                    ->onUpdate('NO ACTION')->onDelete('CASCADE');
            }
            if (!Utils::hasForeignKey('domain', 'domain_language_id_foreign', 'mysql')) {
                $table->foreign('language_id')->references('id')->on('language')
                    ->onUpdate('NO ACTION')->onDelete('SET NULL');
            }
            if (!Utils::hasForeignKey('domain', 'domain_parent_id_foreign', 'mysql')) {
                $table->foreign('parent_id')->references('id')->on('domain')
                    ->onUpdate('SET NULL')->onDelete('SET NULL');
            }
            if (!Utils::hasForeignKey('domain', 'domain_user_id_foreign', 'mysql')) {
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
        Schema::connection('mysql')->table('domain', function (Blueprint $table) {
            $table->dropForeign('domain_domain_thematic_id_foreign');
            $table->dropForeign('domain_domain_volume_id_foreign');
            $table->dropForeign('domain_language_id_foreign');
            $table->dropForeign('domain_parent_id_foreign');
            $table->dropForeign('domain_user_id_foreign');
        });
    }

}
