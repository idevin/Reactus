<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateCity extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('city')) {
            Schema::connection('mysql')->create('city', function (Blueprint $table) {
                $table->increments('id');
                $table->bigInteger('country_id')->unsigned();
                $table->integer('region_id')->nullable();
                $table->boolean('important');
                $table->string('title_ru')->nullable();
                $table->string('area_ru')->nullable();
                $table->string('region_ru')->nullable();
                $table->string('title_ua')->nullable();
                $table->string('area_ua')->nullable();
                $table->string('region_ua')->nullable();
                $table->string('title_be')->nullable();
                $table->string('area_be')->nullable();
                $table->string('region_be')->nullable();
                $table->string('title_en')->nullable();
                $table->string('area_en')->nullable();
                $table->string('region_en')->nullable();
                $table->string('title_es')->nullable();
                $table->string('area_es')->nullable();
                $table->string('region_es')->nullable();
                $table->string('title_pt')->nullable();
                $table->string('area_pt')->nullable();
                $table->string('region_pt')->nullable();
                $table->string('title_de')->nullable();
                $table->string('area_de')->nullable();
                $table->string('region_de')->nullable();
                $table->string('title_fr')->nullable();
                $table->string('area_fr')->nullable();
                $table->string('region_fr')->nullable();
                $table->string('title_it')->nullable();
                $table->string('area_it')->nullable();
                $table->string('region_it')->nullable();
                $table->string('title_pl')->nullable();
                $table->string('area_pl')->nullable();
                $table->string('region_pl')->nullable();
                $table->string('title_ja')->nullable();
                $table->string('area_ja')->nullable();
                $table->string('region_ja')->nullable();
                $table->string('title_lt')->nullable();
                $table->string('area_lt')->nullable();
                $table->string('region_lt')->nullable();
                $table->string('title_lv')->nullable();
                $table->string('area_lv')->nullable();
                $table->string('region_lv')->nullable();
                $table->string('title_cz')->nullable();
                $table->string('area_cz')->nullable();
                $table->string('region_cz')->nullable();
            });
        } else {
            Schema::connection('mysql')->table('city', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('city', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('city', 'country_id')) {
                    $table->bigInteger('country_id')->unsigned()->index('city_country_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('city', 'region_id')) {
                    $table->integer('region_id')->nullable()->index('city_region_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('city', 'important')) {
                    $table->boolean('important');
                }
                if (!Schema::connection('mysql')->hasColumn('city', 'title_ru')) {
                    $table->string('title_ru')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('city', 'area_ru')) {
                    $table->string('area_ru')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('city', 'region_ru')) {
                    $table->string('region_ru')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('city', 'title_ua')) {
                    $table->string('title_ua')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('city', 'area_ua')) {
                    $table->string('area_ua')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('city', 'region_ua')) {
                    $table->string('region_ua')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('city', 'title_be')) {
                    $table->string('title_be')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('city', 'area_be')) {
                    $table->string('area_be')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('city', 'region_be')) {
                    $table->string('region_be')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('city', 'title_en')) {
                    $table->string('title_en')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('city', 'area_en')) {
                    $table->string('area_en')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('city', 'region_en')) {
                    $table->string('region_en')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('city', 'title_es')) {
                    $table->string('title_es')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('city', 'area_es')) {
                    $table->string('area_es')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('city', 'region_es')) {
                    $table->string('region_es')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('city', 'title_pt')) {
                    $table->string('title_pt')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('city', 'area_pt')) {
                    $table->string('area_pt')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('city', 'region_pt')) {
                    $table->string('region_pt')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('city', 'title_de')) {
                    $table->string('title_de')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('city', 'area_de')) {
                    $table->string('area_de')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('city', 'region_de')) {
                    $table->string('region_de')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('city', 'title_fr')) {
                    $table->string('title_fr')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('city', 'area_fr')) {
                    $table->string('area_fr')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('city', 'region_fr')) {
                    $table->string('region_fr')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('city', 'title_it')) {
                    $table->string('title_it')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('city', 'area_it')) {
                    $table->string('area_it')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('city', 'region_it')) {
                    $table->string('region_it')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('city', 'title_pl')) {
                    $table->string('title_pl')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('city', 'area_pl')) {
                    $table->string('area_pl')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('city', 'region_pl')) {
                    $table->string('region_pl')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('city', 'title_ja')) {
                    $table->string('title_ja')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('city', 'area_ja')) {
                    $table->string('area_ja')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('city', 'region_ja')) {
                    $table->string('region_ja')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('city', 'title_lt')) {
                    $table->string('title_lt')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('city', 'area_lt')) {
                    $table->string('area_lt')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('city', 'region_lt')) {
                    $table->string('region_lt')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('city', 'title_lv')) {
                    $table->string('title_lv')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('city', 'area_lv')) {
                    $table->string('area_lv')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('city', 'region_lv')) {
                    $table->string('region_lv')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('city', 'title_cz')) {
                    $table->string('title_cz')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('city', 'area_cz')) {
                    $table->string('area_cz')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('city', 'region_cz')) {
                    $table->string('region_cz')->nullable();
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
        Schema::connection('mysql')->drop('city');
    }

}