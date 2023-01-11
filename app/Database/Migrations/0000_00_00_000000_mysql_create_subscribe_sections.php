<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateSubscribeSections extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('subscribe_sections')) {
            Schema::connection('mysql')->create('subscribe_sections', function (Blueprint $table) {
                $table->increments('id');
                $table->bigInteger('user_id')->unsigned()->index('subscribe_sections_user_id_foreign');
                $table->bigInteger('section_id')->unsigned()->index('subscribe_sections_section_id_foreign');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
            });
        } else {
            Schema::connection('mysql')->table('subscribe_sections', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('subscribe_sections', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('subscribe_sections', 'user_id')) {
                    $table->bigInteger('user_id')->unsigned()->index('subscribe_sections_user_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('subscribe_sections', 'section_id')) {
                    $table->bigInteger('section_id')->unsigned()->index('subscribe_sections_section_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('subscribe_sections', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('subscribe_sections', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
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
        Schema::connection('mysql')->drop('subscribe_sections');
    }

}