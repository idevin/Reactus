<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateSectionSite extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('section_site')) {
            Schema::connection('mysql')->create('section_site', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('site_id')->unsigned()->index('section_site_site_id_foreign');
                $table->integer('from_site_id')->unsigned()->index('section_site_from_site_id_foreign');
                $table->bigInteger('section_id')->unsigned()->nullable()->index('section_site_section_id_foreign');
                $table->bigInteger('to_section_id')->unsigned()->nullable()->index('section_site_to_section_id_foreign');
                $table->boolean('announce')->default("1");
                $table->boolean('moderated');
            });
        } else {
            Schema::connection('mysql')->table('section_site', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('section_site', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('section_site', 'site_id')) {
                    $table->integer('site_id')->unsigned()->index('section_site_site_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('section_site', 'from_site_id')) {
                    $table->integer('from_site_id')->unsigned()->index('section_site_from_site_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('section_site', 'section_id')) {
                    $table->bigInteger('section_id')->unsigned()->nullable()->index('section_site_section_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('section_site', 'to_section_id')) {
                    $table->bigInteger('to_section_id')->unsigned()->nullable()->index('section_site_to_section_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('section_site', 'announce')) {
                    $table->boolean('announce')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('section_site', 'moderated')) {
                    $table->boolean('moderated');
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
        Schema::connection('mysql')->drop('section_site');
    }

}