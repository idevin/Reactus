<?php

namespace App\Traits;

trait FieldGroup
{
    private function createFieldGroup($name, $fieldGroupNumber)
    {
        $name = trim($name);
        $fieldGroupClass = static::$fieldGroups[$fieldGroupNumber];
        $oFieldGroup = $fieldGroupClass::where(['name' => $name])->get()->first();

        if (empty($oFieldGroup)) {
            $oFieldGroup = $fieldGroupClass::create(['name' => $name]);
        }

        return $oFieldGroup;
    }

    /**
     * @param $class
     * @return array
     * @internal param int $depth
     */
    private function getFieldGroups($class): array
    {
        $fieldGroupsArray = [];

        foreach ($class::all('id', 'name')->toArray() as $fieldGroup) {
            $fieldGroupsArray[$fieldGroup['id']] = $fieldGroup['name'];
        }
        return $fieldGroupsArray;
    }
}