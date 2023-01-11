<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDomainVolumeSize extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('domain_volume', function (Blueprint $table) {
            $table->float('size')->nullable(false)->default(0.1)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('domain_volume', function (Blueprint $table) {
            $table->float('size')->nullable(false)->default(5)->change();
        });
    }
}
