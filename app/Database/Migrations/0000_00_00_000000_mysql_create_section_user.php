<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateSectionUser extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('section_user')) {
            Schema::connection('mysql')->create('section_user', function (Blueprint $table) {
                $table->increments('id');
                $table->bigInteger('user_id')->unsigned()->index('section_user_user_id_foreign');
                $table->bigInteger('section_id')->unsigned()->index('section_user_section_id_foreign');
            });
        } else {
            Schema::connection('mysql')->table('section_user', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('section_user', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('section_user', 'user_id')) {
                    $table->bigInteger('user_id')->unsigned()->index('section_user_user_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('section_user', 'section_id')) {
                    $table->bigInteger('section_id')->unsigned()->index('section_user_section_id_foreign');
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
        Schema::connection('mysql')->drop('section_user');
    }

}