<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateDomainMirror extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('domain_mirror')) {
            Schema::connection('mysql')->create('domain_mirror', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('domain_id')->unsigned()->index('domain_mirror_domain_id_foreign');
                $table->integer('domain_mirror_id')->unsigned()->index('domain_mirror_domain_mirror_id_foreign');
            });
        } else {
            Schema::connection('mysql')->table('domain_mirror', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('domain_mirror', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('domain_mirror', 'domain_id')) {
                    $table->integer('domain_id')->unsigned()->index('domain_mirror_domain_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('domain_mirror', 'domain_mirror_id')) {
                    $table->integer('domain_mirror_id')->unsigned()->index('domain_mirror_domain_mirror_id_foreign');
                }
            });
        }
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql')->drop('domain_mirror');
    }

}