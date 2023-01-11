<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqluCreateFeedbackLog extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysqlu')->hasTable('feedback_log')) {
            Schema::connection('mysqlu')->create('feedback_log', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('site_id')->unsigned()->index('feedback_log_site_id_foreign');
                $table->bigInteger('from_user_id')->unsigned()->nullable()->index('feedback_log_from_user_id_foreign');
                $table->string('from_name')->nullable();
                $table->string('from_email')->nullable();
                $table->string('from_phone')->nullable();
                $table->json('to_emails')->nullable();
                $table->bigInteger('to_user_id')->unsigned()->nullable()->index('feedback_log_to_user_id_foreign');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
            });
        } else {
            Schema::connection('mysqlu')->table('feedback_log', function (Blueprint $table) {
                if (!Schema::connection('mysqlu')->hasColumn('feedback_log', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysqlu')->hasColumn('feedback_log', 'site_id')) {
                    $table->integer('site_id')->unsigned()->index('feedback_log_site_id_foreign');
                }
                if (!Schema::connection('mysqlu')->hasColumn('feedback_log', 'from_user_id')) {
                    $table->bigInteger('from_user_id')->unsigned()->nullable()->index('feedback_log_from_user_id_foreign');
                }
                if (!Schema::connection('mysqlu')->hasColumn('feedback_log', 'from_name')) {
                    $table->string('from_name')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('feedback_log', 'from_email')) {
                    $table->string('from_email')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('feedback_log', 'from_phone')) {
                    $table->string('from_phone')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('feedback_log', 'to_emails')) {
                    $table->json('to_emails')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('feedback_log', 'to_user_id')) {
                    $table->bigInteger('to_user_id')->unsigned()->nullable()->index('feedback_log_to_user_id_foreign');
                }
                if (!Schema::connection('mysqlu')->hasColumn('feedback_log', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('feedback_log', 'updated_at')) {
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
        Schema::connection('mysqlu')->drop('feedback_log');
    }

}