<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateComplainOption extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('complain_option')) {
            Schema::connection('mysql')->create('complain_option', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('parent_id')->nullable()->index('complain_option_parent_id_foreign');
                $table->integer('lft')->nullable();
                $table->integer('rgt')->nullable();
                $table->integer('depth')->nullable();
                $table->string('title');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->integer('value');
            });
        } else {
            Schema::connection('mysql')->table('complain_option', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('complain_option', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('complain_option', 'parent_id')) {
                    $table->integer('parent_id')->nullable()->index('complain_option_parent_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('complain_option', 'lft')) {
                    $table->integer('lft')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('complain_option', 'rgt')) {
                    $table->integer('rgt')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('complain_option', 'depth')) {
                    $table->integer('depth')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('complain_option', 'title')) {
                    $table->string('title');
                }
                if (!Schema::connection('mysql')->hasColumn('complain_option', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('complain_option', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('complain_option', 'value')) {
                    $table->integer('value');
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
        Schema::connection('mysql')->drop('complain_option');
    }

}