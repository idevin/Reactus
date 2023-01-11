<?php

namespace App\Traits;

trait Catalog
{
    public static function createCatalogValidator($data, $except = [], $customErrors = [], $customMessages = [])
    {
        $default = [
            'position' => 'required',
            'module_id' => 'required'
        ];

        $messages = [
            'position.required' => 'Не задана позиция блока',
            'module_id.required' => 'Не задан ID модуля'
        ];

        return Utils::makeValidator($data, $messages, $customMessages, $default, $customErrors, $except);
    }
}