<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDomainIsCustomerDomain extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('domain', function (Blueprint $table) {
            $table->renameColumn('custom_domain', 'is_customer_domain');
        });

        Schema::table('domain', function (Blueprint $table) {
            $table->boolean('is_customer_domain')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('domain', function (Blueprint $table) {
            $table->renameColumn('is_customer_domain', 'custom_domain');
        });

        Schema::table('domain', function (Blueprint $table) {
            $table->string('custom_domain')->nullable()->change();
        });
    }
}
