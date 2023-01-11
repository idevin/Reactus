<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateSiteSection extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('site_section')) {
            Schema::connection('mysql')->create('site_section', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('site_id')->unsigned()->index('site_section_site_id_foreign');
                $table->bigInteger('section_id')->unsigned()->index('site_section_section_id_foreign');
                $table->integer('template_id')->unsigned()->index('site_section_template_id_foreign');
                $table->boolean('active')->default("1");
            });
        } else {
            Schema::connection('mysql')->table('site_section', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('site_section', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('site_section', 'site_id')) {
                    $table->integer('site_id')->unsigned()->index('site_section_site_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('site_section', 'section_id')) {
                    $table->bigInteger('section_id')->unsigned()->index('site_section_section_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('site_section', 'template_id')) {
                    $table->integer('template_id')->unsigned()->index('site_section_template_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('site_section', 'active')) {
                    $table->boolean('active')->default("1");
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
        Schema::connection('mysql')->drop('site_section');
    }

}