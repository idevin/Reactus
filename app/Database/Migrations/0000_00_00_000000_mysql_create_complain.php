<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateComplain extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('complain')) {
            Schema::connection('mysql')->create('complain', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('complain_option_id')->unsigned()->index('complain_complain_option_id_foreign');
                $table->bigInteger('user_id')->unsigned()->index('complain_user_id_foreign');
                $table->bigInteger('on_user_id')->unsigned()->index('complain_on_user_id_foreign');
                $table->text('content');
                $table->string('object');
                $table->integer('object_id')->index('complain_object_id_foreign');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->integer('parent_object_id')->index('complain_parent_object_id_foreign');
                $table->integer('status');
                $table->string('answer');
                $table->bigInteger('moderator_id')->unsigned()->index('complain_moderator_id_foreign');
            });
        } else {
            Schema::connection('mysql')->table('complain', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('complain', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('complain', 'complain_option_id')) {
                    $table->integer('complain_option_id')->unsigned()->index('complain_complain_option_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('complain', 'user_id')) {
                    $table->bigInteger('user_id')->unsigned()->index('complain_user_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('complain', 'on_user_id')) {
                    $table->bigInteger('on_user_id')->unsigned()->index('complain_on_user_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('complain', 'content')) {
                    $table->text('content');
                }
                if (!Schema::connection('mysql')->hasColumn('complain', 'object')) {
                    $table->string('object');
                }
                if (!Schema::connection('mysql')->hasColumn('complain', 'object_id')) {
                    $table->integer('object_id')->index('complain_object_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('complain', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('complain', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('complain', 'parent_object_id')) {
                    $table->integer('parent_object_id')->index('complain_parent_object_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('complain', 'status')) {
                    $table->integer('status');
                }
                if (!Schema::connection('mysql')->hasColumn('complain', 'answer')) {
                    $table->string('answer');
                }
                if (!Schema::connection('mysql')->hasColumn('complain', 'moderator_id')) {
                    $table->bigInteger('moderator_id')->unsigned()->index('complain_moderator_id_foreign');
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
        Schema::connection('mysql')->drop('complain');
    }

}