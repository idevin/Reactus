<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateSectionRole extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('section_role')) {
            Schema::connection('mysql')->create('section_role', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('role_id')->unsigned()->index('section_role_role_id_foreign');
                $table->bigInteger('user_id')->unsigned()->index('section_role_user_id_foreign');
                $table->bigInteger('section_id')->unsigned()->index('section_role_section_id_foreign');
            });
        } else {
            Schema::connection('mysql')->table('section_role', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('section_role', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('section_role', 'role_id')) {
                    $table->integer('role_id')->unsigned()->index('section_role_role_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('section_role', 'user_id')) {
                    $table->bigInteger('user_id')->unsigned()->index('section_role_user_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('section_role', 'section_id')) {
                    $table->bigInteger('section_id')->unsigned()->index('section_role_section_id_foreign');
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
        Schema::connection('mysql')->drop('section_role');
    }

}