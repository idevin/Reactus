<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateRegion extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('region')) {
            Schema::connection('mysql')->create('region', function (Blueprint $table) {
                $table->increments('id');
                $table->bigInteger('country_id')->unsigned();
                $table->string('title_ru')->nullable();
                $table->string('title_ua')->nullable();
                $table->string('title_be')->nullable();
                $table->string('title_en')->nullable();
                $table->string('title_es')->nullable();
                $table->string('title_pt')->nullable();
                $table->string('title_de')->nullable();
                $table->string('title_fr')->nullable();
                $table->string('title_it')->nullable();
                $table->string('title_pl')->nullable();
                $table->string('title_ja')->nullable();
                $table->string('title_lt')->nullable();
                $table->string('title_lv')->nullable();
                $table->string('title_cz')->nullable();
            });
        } else {
            Schema::connection('mysql')->table('region', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('region', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('region', 'country_id')) {
                    $table->bigInteger('country_id')->unsigned();
                }
                if (!Schema::connection('mysql')->hasColumn('region', 'title_ru')) {
                    $table->string('title_ru')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('region', 'title_ua')) {
                    $table->string('title_ua')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('region', 'title_be')) {
                    $table->string('title_be')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('region', 'title_en')) {
                    $table->string('title_en')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('region', 'title_es')) {
                    $table->string('title_es')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('region', 'title_pt')) {
                    $table->string('title_pt')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('region', 'title_de')) {
                    $table->string('title_de')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('region', 'title_fr')) {
                    $table->string('title_fr')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('region', 'title_it')) {
                    $table->string('title_it')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('region', 'title_pl')) {
                    $table->string('title_pl')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('region', 'title_ja')) {
                    $table->string('title_ja')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('region', 'title_lt')) {
                    $table->string('title_lt')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('region', 'title_lv')) {
                    $table->string('title_lv')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('region', 'title_cz')) {
                    $table->string('title_cz')->nullable();
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
        Schema::connection('mysql')->drop('region');
    }

}