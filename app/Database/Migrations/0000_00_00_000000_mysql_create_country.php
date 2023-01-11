<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateCountry extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('country')) {
            Schema::connection('mysql')->create('country', function (Blueprint $table) {
                $table->bigIncrements('id');
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
                $table->string('title_br')->nullable();
                $table->string('title_nl')->nullable();
                $table->string('title_hr')->nullable();
                $table->string('title_fa')->nullable();
                $table->json('top_level_domain')->nullable();
                $table->string('alpha2_code')->nullable();
                $table->string('alpha3_code')->nullable();
                $table->string('capital')->nullable();
                $table->string('region')->nullable();
                $table->string('subregion')->nullable();
                $table->string('cioc')->nullable();
                $table->string('numeric_code')->nullable();
                $table->json('languages')->nullable();
                $table->json('currencies')->nullable();
                $table->json('lat_lng')->nullable();
                $table->json('calling_codes')->nullable();
                $table->json('borders')->nullable();
                $table->json('timezones')->nullable();
            });
        } else {
            Schema::connection('mysql')->table('country', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('country', 'id')) {
                    $table->bigIncrements('id');
                }
                if (!Schema::connection('mysql')->hasColumn('country', 'title_ru')) {
                    $table->string('title_ru')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('country', 'title_ua')) {
                    $table->string('title_ua')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('country', 'title_be')) {
                    $table->string('title_be')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('country', 'title_en')) {
                    $table->string('title_en')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('country', 'title_es')) {
                    $table->string('title_es')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('country', 'title_pt')) {
                    $table->string('title_pt')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('country', 'title_de')) {
                    $table->string('title_de')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('country', 'title_fr')) {
                    $table->string('title_fr')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('country', 'title_it')) {
                    $table->string('title_it')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('country', 'title_pl')) {
                    $table->string('title_pl')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('country', 'title_ja')) {
                    $table->string('title_ja')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('country', 'title_lt')) {
                    $table->string('title_lt')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('country', 'title_lv')) {
                    $table->string('title_lv')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('country', 'title_cz')) {
                    $table->string('title_cz')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('country', 'title_br')) {
                    $table->string('title_br')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('country', 'title_nl')) {
                    $table->string('title_nl')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('country', 'title_hr')) {
                    $table->string('title_hr')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('country', 'title_fa')) {
                    $table->string('title_fa')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('country', 'top_level_domain')) {
                    $table->json('top_level_domain')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('country', 'alpha2_code')) {
                    $table->string('alpha2_code')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('country', 'alpha3_code')) {
                    $table->string('alpha3_code')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('country', 'capital')) {
                    $table->string('capital')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('country', 'region')) {
                    $table->string('region')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('country', 'subregion')) {
                    $table->string('subregion')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('country', 'cioc')) {
                    $table->string('cioc')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('country', 'numeric_code')) {
                    $table->string('numeric_code')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('country', 'languages')) {
                    $table->json('languages')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('country', 'currencies')) {
                    $table->json('currencies')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('country', 'lat_lng')) {
                    $table->json('lat_lng')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('country', 'calling_codes')) {
                    $table->json('calling_codes')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('country', 'borders')) {
                    $table->json('borders')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('country', 'timezones')) {
                    $table->json('timezones')->nullable();
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
        Schema::connection('mysql')->drop('country');
    }

}