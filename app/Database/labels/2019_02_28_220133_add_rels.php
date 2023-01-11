<?php

use Vinelab\NeoEloquent\Migrations\Migration;

class AddRels extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     * @throws \GraphAware\Neo4j\Client\Exception\Neo4jExceptionInterface
     */
    public function up()
    {
        \App\Models\NeoCatalog::client()->run('MATCH (a:UserData),(b:Object)
         CREATE (a)-[r:USER_DATA]->(b) 
         RETURN type(r)');
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
