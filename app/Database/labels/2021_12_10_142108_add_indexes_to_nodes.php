<?php

use App\Models\Neo4j;
use Vinelab\NeoEloquent\Migrations\Migration;

class AddIndexesToNodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $cql = "CALL db.index.fulltext.createNodeIndex('user_values', ['UserField'], ['value'])";
        Neo4j::client()->run($cql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $cql = "DROP INDEX 'user_values' IF EXISTS";
        Neo4j::client()->run($cql);
    }
}
