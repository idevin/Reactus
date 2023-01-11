<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateAnnouncement extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('announcement')) {
            Schema::connection('mysql')->create('announcement', function (Blueprint $table) {
                $table->increments('id');
                $table->bigInteger('object_id')->index('announcement_object_id_foreign');
                $table->string('object_type');
                $table->string('title');
                $table->text('description')->nullable();
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->integer('site_id')->unsigned()->index('announcement_site_id_foreign');
                $table->string('announce_type');
                $table->integer('announce_id')->index('announcement_announce_id_foreign');
            });
        } else {
            Schema::connection('mysql')->table('announcement', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('announcement', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('announcement', 'object_id')) {
                    $table->bigInteger('object_id')->index('announcement_object_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('announcement', 'object_type')) {
                    $table->string('object_type');
                }
                if (!Schema::connection('mysql')->hasColumn('announcement', 'title')) {
                    $table->string('title');
                }
                if (!Schema::connection('mysql')->hasColumn('announcement', 'description')) {
                    $table->text('description')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('announcement', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('announcement', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('announcement', 'site_id')) {
                    $table->integer('site_id')->unsigned()->index('announcement_site_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('announcement', 'announce_type')) {
                    $table->string('announce_type');
                }
                if (!Schema::connection('mysql')->hasColumn('announcement', 'announce_id')) {
                    $table->integer('announce_id')->index('announcement_announce_id_foreign');
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
        Schema::connection('mysql')->drop('announcement');
    }

}