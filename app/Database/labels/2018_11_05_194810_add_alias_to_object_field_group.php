<?php

use Vinelab\NeoEloquent\Migrations\Migration;

class AddAliasToObjectFieldGroup extends Migration
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
                $oFieldGroup->update([
                    'alias' => md5($oFieldGroup->id)
                ]);
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
