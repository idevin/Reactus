<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateFeedback extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('feedback')) {
            Schema::connection('mysql')->create('feedback', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('site_id')->unsigned()->index('feedback_site_id_foreign');
                $table->integer('field_id')->unsigned()->index('feedback_field_id_foreign');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->boolean('for_all_sites');
                $table->integer('sort_order')->nullable();
            });
        } else {
            Schema::connection('mysql')->table('feedback', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('feedback', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('feedback', 'site_id')) {
                    $table->integer('site_id')->unsigned()->index('feedback_site_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('feedback', 'field_id')) {
                    $table->integer('field_id')->unsigned()->index('feedback_field_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('feedback', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('feedback', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('feedback', 'for_all_sites')) {
                    $table->boolean('for_all_sites');
                }
                if (!Schema::connection('mysql')->hasColumn('feedback', 'sort_order')) {
                    $table->integer('sort_order')->nullable();
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
        Schema::connection('mysql')->drop('feedback');
    }

}