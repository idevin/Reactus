<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateModuleContacts extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('module_contacts')) {
            Schema::connection('mysql')->create('module_contacts', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('site_id')->unsigned()->index('module_contacts_site_id_foreign');
                $table->integer('sort_order')->default("1");
                $table->string('template_id')->nullable()->index('module_contacts_template_id_foreign');
                $table->string('name')->nullable();
                $table->integer('module_id')->unsigned()->nullable()->index('module_contacts_module_id_foreign');
                $table->json('phone')->nullable();
                $table->json('address')->nullable();
            });
        } else {
            Schema::connection('mysql')->table('module_contacts', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('module_contacts', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('module_contacts', 'site_id')) {
                    $table->integer('site_id')->unsigned()->index('module_contacts_site_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('module_contacts', 'sort_order')) {
                    $table->integer('sort_order')->default("1");
                }
                if (!Schema::connection('mysql')->hasColumn('module_contacts', 'template_id')) {
                    $table->string('template_id')->nullable()->index('module_contacts_template_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('module_contacts', 'name')) {
                    $table->string('name')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('module_contacts', 'module_id')) {
                    $table->integer('module_id')->unsigned()->nullable()->index('module_contacts_module_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('module_contacts', 'phone')) {
                    $table->json('phone')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('module_contacts', 'address')) {
                    $table->json('address')->nullable();
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
        Schema::connection('mysql')->drop('module_contacts');
    }

}