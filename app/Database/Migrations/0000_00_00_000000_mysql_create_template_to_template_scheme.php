<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateTemplateToTemplateScheme extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('template_to_template_scheme')) {
            Schema::connection('mysql')->create('template_to_template_scheme', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('template_id')->unsigned()->index('template_to_template_scheme_template_id_foreign');
                $table->integer('template_scheme_id')->unsigned()->index('template_to_template_scheme_template_scheme_id_foreign');
            });
        } else {
            Schema::connection('mysql')->table('template_to_template_scheme', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('template_to_template_scheme', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('template_to_template_scheme', 'template_id')) {
                    $table->integer('template_id')->unsigned()->index('template_to_template_scheme_template_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('template_to_template_scheme', 'template_scheme_id')) {
                    $table->integer('template_scheme_id')->unsigned()->index('template_to_template_scheme_template_scheme_id_foreign');
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
        Schema::connection('mysql')->drop('template_to_template_scheme');
    }

}