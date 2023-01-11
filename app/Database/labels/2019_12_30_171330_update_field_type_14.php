<?php

use App\Models\NeoField;
use Vinelab\NeoEloquent\Migrations\Migration;

class UpdateFieldType14 extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $objectField = NeoField::all();

        foreach ($objectField as $field) {
            if ($field && is_file($field->value)) {
                if (!file_exists($field->value)) {
                    $field->update(['value' => '']);
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
