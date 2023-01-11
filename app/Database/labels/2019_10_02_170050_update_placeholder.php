<?php

use App\Models\Neo4j;
use Vinelab\NeoEloquent\Migrations\Migration;

class UpdatePlaceholder extends Migration
{
    /**
     * Run the migrations.
     *
     *
     * @return void
     */
    public function up()
    {
        Neo4j::client()->run('MATCH (n:Field) WHERE EXISTS(n.default_value) SET 
        n.placeholder=n.default_value REMOVE n.default_value RETURN n.placeholder');
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
