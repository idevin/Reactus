<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateTemplateSchemeColor extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('template_scheme_color')) {
            Schema::connection('mysql')->create('template_scheme_color', function (Blueprint $table) {
                $table->integer('template_scheme_id')->unsigned()->index('template_scheme_color_template_scheme_id_foreign');
                $table->string('color');
            });
        } else {
            Schema::connection('mysql')->table('template_scheme_color', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('template_scheme_color', 'template_scheme_id')) {
                    $table->integer('template_scheme_id')->unsigned()->index('template_scheme_color_template_scheme_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('template_scheme_color', 'color')) {
                    $table->string('color');
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
        Schema::connection('mysql')->drop('template_scheme_color');
    }

}