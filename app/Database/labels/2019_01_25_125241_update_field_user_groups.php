<?php

use Vinelab\NeoEloquent\Migrations\Migration;

class UpdateFieldUserGroups extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $fieldGroups = \App\Models\NeoUserFieldGroup::all();

        foreach ($fieldGroups as $fieldGroup) {
            $oFieldGroup = \App\Models\NeoCatalogFieldGroup::find($fieldGroup->object_field_group_id);
            if ($oFieldGroup) {
                $fieldGroup->update(['sort' => $oFieldGroup->sort]);
            }
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
