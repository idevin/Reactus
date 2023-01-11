<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqluCreateRole extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysqlu')->hasTable('role')) {
            Schema::connection('mysqlu')->create('role', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('description');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->boolean('is_default');
                $table->boolean('for_registered')->nullable();
                $table->boolean('is_anon')->nullable();
                $table->boolean('is_root');
            });
        } else {
            Schema::connection('mysqlu')->table('role', function (Blueprint $table) {
                if (!Schema::connection('mysqlu')->hasColumn('role', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysqlu')->hasColumn('role', 'name')) {
                    $table->string('name');
                }
                if (!Schema::connection('mysqlu')->hasColumn('role', 'description')) {
                    $table->string('description');
                }
                if (!Schema::connection('mysqlu')->hasColumn('role', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('role', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('role', 'is_default')) {
                    $table->boolean('is_default');
                }
                if (!Schema::connection('mysqlu')->hasColumn('role', 'for_registered')) {
                    $table->boolean('for_registered')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('role', 'is_anon')) {
                    $table->boolean('is_anon')->nullable();
                }
                if (!Schema::connection('mysqlu')->hasColumn('role', 'is_root')) {
                    $table->boolean('is_root');
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
        Schema::connection('mysqlu')->drop('role');
    }

}