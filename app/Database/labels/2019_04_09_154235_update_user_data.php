<?php

use Vinelab\NeoEloquent\Migrations\Migration;
use Vinelab\NeoEloquent\Schema\Blueprint;

class UpdateUserData extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Neo4jSchema::label('UserCatalogData', function (Blueprint $label) {
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }

}
