<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTemplatePrototypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('template_prototype', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('template_id')->unsigned();
            $table->string('name');
            $table->string('description')->nullable(true);

            $table->foreign('template_id')->references('id')->on('template')
                ->onUpdate('NO ACTION')->onDelete('CASCADE');
        });

        Schema::create('template_prototype_stroke', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('template_prototype_id')->unsigned();
            $table->integer('position');
            $table->integer('sort_order')->default(1);
            $table->foreign('template_prototype_id', 'fk_prototype_id')
                ->references('id')->on('template_prototype')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });

        Schema::create('template_prototype_stroke_module', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('template_prototype_stroke_id')->unsigned();
            $table->integer('module_id')->unsigned();
            $table->integer('sort_order')->default(1);

            $table->foreign('module_id', 'fk_module_id_id')->references('id')
                ->on('module')->onUpdate('NO ACTION')->onDelete('CASCADE');

            $table->foreign('template_prototype_stroke_id', 'fk_prototype_stroke_id')->references('id')
                ->on('template_prototype_stroke')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('template_prototype_stroke_module');
        Schema::dropIfExists('template_prototype_stroke');
        Schema::dropIfExists('template_prototype');
    }
}
