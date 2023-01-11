<?php

use Vinelab\NeoEloquent\Schema\Blueprint;
use Vinelab\NeoEloquent\Migrations\Migration;

class AddCatalogLabels extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Neo4jSchema::label('Catalog', function(Blueprint $label){});
        Neo4jSchema::label('Product', function(Blueprint $label){});
        Neo4jSchema::label('ProductAttribute', function(Blueprint $label){});
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
