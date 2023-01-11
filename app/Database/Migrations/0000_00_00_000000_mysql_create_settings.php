<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MysqlCreateSettings extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql')->hasTable('settings')) {
            Schema::connection('mysql')->create('settings', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('site_id')->unsigned()->index('settings_site_id_foreign');
                $table->string('yandex_code')->nullable();
                $table->string('google_code')->nullable();
                $table->string('yandex_verification')->nullable();
                $table->string('google_verification')->nullable();
                $table->string('google_tag')->nullable();
                $table->string('seo_title')->nullable();
                $table->string('seo_description')->nullable();
                $table->string('seo_breadcrumbs')->nullable();
            });
        } else {
            Schema::connection('mysql')->table('settings', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('settings', 'id')) {
                    $table->increments('id');
                }
                if (!Schema::connection('mysql')->hasColumn('settings', 'site_id')) {
                    $table->integer('site_id')->unsigned()->index('settings_site_id_foreign');
                }
                if (!Schema::connection('mysql')->hasColumn('settings', 'yandex_code')) {
                    $table->string('yandex_code')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('settings', 'google_code')) {
                    $table->string('google_code')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('settings', 'yandex_verification')) {
                    $table->string('yandex_verification')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('settings', 'google_verification')) {
                    $table->string('google_verification')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('settings', 'google_tag')) {
                    $table->string('google_tag')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('settings', 'seo_title')) {
                    $table->string('seo_title')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('settings', 'seo_description')) {
                    $table->string('seo_description')->nullable();
                }
                if (!Schema::connection('mysql')->hasColumn('settings', 'seo_breadcrumbs')) {
                    $table->string('seo_breadcrumbs')->nullable();
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
        Schema::connection('mysql')->drop('settings');
    }

}