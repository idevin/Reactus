<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBoolHideFieldsToSlide extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('module_slide', function (Blueprint $table) {
            $table->boolean('hide_title')->default(0);
            $table->boolean('hide')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('module_slide', function (Blueprint $table) {
            $table->dropColumn(['hide_title', 'hide']);
        });
    }
}
