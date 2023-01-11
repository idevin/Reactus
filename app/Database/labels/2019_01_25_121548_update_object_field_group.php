<?php

use App\Models\NeoCatalogFieldGroup;
use Vinelab\NeoEloquent\Migrations\Migration;

class UpdateObjectFieldGroup extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $fieldGroups = NeoCatalogFieldGroup::all();

        foreach ($fieldGroups as $fieldGroup) {
            $fieldGroup->update(['sort' => 0]);
        }
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
