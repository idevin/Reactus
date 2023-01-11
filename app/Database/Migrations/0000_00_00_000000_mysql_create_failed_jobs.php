<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateFailedJobs extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('failed_jobs')) {
            Schema::connection('mysql')->create('failed_jobs', function (Blueprint $table) {
                $table->increments('id');
                $table->text('connection');
                $table->text('queue');
                $table->text('payload');
                $table->dateTime('failed_at')->default(DB::raw("CURRENT_TIMESTAMP"));
            });
        } else {
            Schema::connection('mysql')->table('failed_jobs', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('failed_jobs', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('failed_jobs', 'connection')) {
                    $table->text('connection');
                }
                if (!Schema::connection('mysql')->hasColumn('failed_jobs', 'queue')) {
                    $table->text('queue');
                }
                if (!Schema::connection('mysql')->hasColumn('failed_jobs', 'payload')) {
                    $table->text('payload');
                }
                if (!Schema::connection('mysql')->hasColumn('failed_jobs', 'failed_at')) {
                    $table->timestamp('failed_at')->default(DB::raw("CURRENT_TIMESTAMP"));
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
        Schema::connection('mysql')->drop('failed_jobs');
    }

}