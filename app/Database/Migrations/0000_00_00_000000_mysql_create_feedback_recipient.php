<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateFeedbackRecipient extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('feedback_recipient')) {
            Schema::connection('mysql')->create('feedback_recipient', function (Blueprint $table) {
                        $table->increments('id');
        $table->integer('site_id')->unsigned()->index('feedback_recipient_site_id_foreign');
        $table->string('email');
            });
        } else {
            Schema::connection('mysql')->table('feedback_recipient', function (Blueprint $table) {
                        if (!Schema::connection('mysql')->hasColumn('feedback_recipient', 'id')) {
                        $table->increments('id');
        }
        if (!Schema::connection('mysql')->hasColumn('feedback_recipient', 'site_id')) {
                        $table->integer('site_id')->unsigned()->index('feedback_recipient_site_id_foreign');
        }
        if (!Schema::connection('mysql')->hasColumn('feedback_recipient', 'email')) {
                        $table->string('email');
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
        Schema::connection('mysql')->drop('feedback_recipient');
    }

}