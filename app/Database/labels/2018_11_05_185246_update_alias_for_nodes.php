<?php

use Vinelab\NeoEloquent\Migrations\Migration;

class UpdateAliasForNodes extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $oFieldGroups = \App\Models\NeoCatalogFieldGroup::all();
        if (count($oFieldGroups) > 0) {
            foreach ($oFieldGroups as $oFieldGroup) {
                $fields = $oFieldGroup->fields;
                if (count($fields) > 0) {
                    foreach ($fields as $field) {
                        if (empty($field->alias)) {
                            $field->update([
                                'alias' => md5($field->id)
                            ]);
                        }
                    }
                }
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
