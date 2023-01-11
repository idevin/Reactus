<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateAnchor extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('anchor')) {
            Schema::connection('mysql')->create('anchor', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('anchor_id')->index('anchor_anchor_id_foreign');
                $table->integer('anchor_type');
                $table->string('name')->nullable();
                $table->string('alias')->nullable();
            });
        } else {
            Schema::connection('mysql')->table('anchor', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('anchor', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('anchor', 'anchor_id')) {
                    $table->integer('anchor_id')->index('anchor_anchor_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('anchor', 'anchor_type')) {
                    $table->integer('anchor_type');
                }
                if (!Schema::connection('mysql')->hasColumn('anchor', 'name')) {
                    $table->string('name')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('anchor', 'alias')) {
                    $table->string('alias')->nullable();
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
        Schema::connection('mysql')->drop('anchor');
    }

}