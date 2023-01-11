<?php

use Vinelab\NeoEloquent\Schema\Blueprint;
use Vinelab\NeoEloquent\Migrations\Migration;

class AddIndexesToNew extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Neo4jSchema::label('Field', function(Blueprint $label)
        {
            $label->index('object_field_id');
        });

        Neo4jSchema::label('FieldUserGroup', function(Blueprint $label)
        {
            $label->index('object_field_group_id');
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
