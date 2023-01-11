<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqluCreateFeedbackLogField extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysqlu')->hasTable('feedback_log_field')) {
            Schema::connection('mysqlu')->create('feedback_log_field', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('feedback_log_id')->unsigned()->index('feedback_log_field_feedback_log_id_foreign');
                $table->integer('field_id')->unsigned()->index('feedback_log_field_field_id_foreign');
                $table->string('value')->nullable();
            });
        } else {
            Schema::connection('mysqlu')->table('feedback_log_field', function (Blueprint $table) {
                if (!Schema::connection('mysqlu')->hasColumn('feedback_log_field', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysqlu')->hasColumn('feedback_log_field', 'feedback_log_id')) {
                    $table->integer('feedback_log_id')->unsigned()->index('feedback_log_field_feedback_log_id_foreign');
                }
                if (!Schema::connection('mysqlu')->hasColumn('feedback_log_field', 'field_id')) {
                    $table->integer('field_id')->unsigned()->index('feedback_log_field_field_id_foreign');
                }
                if (!Schema::connection('mysqlu')->hasColumn('feedback_log_field', 'value')) {
                    $table->string('value')->nullable();
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
        Schema::connection('mysqlu')->drop('feedback_log_field');
    }

}