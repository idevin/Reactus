<?php

namespace App\Traits;

use Validator;

trait Information
{
    public static function createInformationValidator($data, $except = [],
                                                      $customErrors = [], $customMessages = [])
    {
        if (isset($data['content'])) {
            $data['content'] = Utils::htmlDecode($data['content']);
        }

        $max = 70;

        $default = [
            'content' => 'required|max:' . $max,
            'position' => 'required',
            'module_id' => 'required'
        ];

        $messages = [
            'content.required' => 'Не написана информация',
            'content.max' => 'Количество символов не должно превышать ' . $max,
            'position.required' => 'Не задана позиция блока',
            'module_id.required' => 'Не задан ID модуля'
        ];

        return Utils::makeValidator($data, $messages, $customMessages, $default, $customErrors, $except);
    }
}