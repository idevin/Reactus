<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateDomain extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('domain')) {
            Schema::connection('mysql')->create('domain', function (Blueprint $table) {
                $table->increments('id');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->integer('parent_id')->unsigned()->nullable()->index('domain_parent_id_foreign');
                $table->string('name');
                $table->string('ssl')->default(1);
                $table->boolean('domain_type')->unsigned();
                $table->boolean('is_default')->unsigned();
                $table->boolean('environment');
                $table->bigInteger('user_id')->unsigned()->nullable()->index('domain_user_id_foreign');
                $table->text('info')->nullable();
                $table->integer('domain_thematic_id')->unsigned()->nullable()->index('domain_domain_thematic_id_foreign');
                $table->integer('language_id')->unsigned()->nullable()->index('domain_language_id_foreign');
                $table->boolean('hide_from_registration');
                $table->boolean('active')->default(1);
                $table->string('custom_domain')->nullable();
                $table->integer('domain_volume_id')->unsigned()->nullable()->index('domain_domain_volume_id_foreign');
            });
        } else {
            Schema::connection('mysql')->table('domain', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('domain', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('domain', 'created_at')) {
                    $table->dateTime('created_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('domain', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('domain', 'parent_id')) {
                    $table->integer('parent_id')->unsigned()->nullable()->index('domain_parent_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('domain', 'name')) {
                    $table->string('name');
                }
                if (!Schema::connection('mysql')->hasColumn('domain', 'domain_type')) {
                    $table->boolean('domain_type')->unsigned();
                }
                if (!Schema::connection('mysql')->hasColumn('domain', 'is_default')) {
                    $table->boolean('is_default')->unsigned();
                }
                if (!Schema::connection('mysql')->hasColumn('domain', 'ssl')) {
                    $table->boolean('ssl')->default(1);
                }
                if (!Schema::connection('mysql')->hasColumn('domain', 'environment')) {
                    $table->boolean('environment');
                }
                if (!Schema::connection('mysql')->hasColumn('domain', 'user_id')) {
                    $table->bigInteger('user_id')->unsigned()->nullable()->index('domain_user_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('domain', 'info')) {
                    $table->text('info')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('domain', 'domain_thematic_id')) {
                    $table->integer('domain_thematic_id')->unsigned()->nullable()->index('domain_domain_thematic_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('domain', 'language_id')) {
                    $table->integer('language_id')->unsigned()->nullable()->index('domain_language_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('domain', 'hide_from_registration')) {
                    $table->boolean('hide_from_registration');
                }
                if (!Schema::connection('mysql')->hasColumn('domain', 'active')) {
                    $table->boolean('active')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('domain', 'custom_domain')) {
                    $table->string('custom_domain')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('domain', 'domain_volume_id')) {
                    $table->integer('domain_volume_id')->unsigned()->nullable()->index('domain_domain_volume_id_foreign');
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
        Schema::connection('mysql')->drop('domain');
    }

}