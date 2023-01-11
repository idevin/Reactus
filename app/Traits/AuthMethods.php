<?php

namespace App\Traits;

use App\Models\RegisterCode;

trait AuthMethods
{
    protected function loadRegisterCode($input)
    {
        $phone = null;
        $email = null;
        $code = $input['code'];

        if (!empty($input['phone'])) {
            $phone = preg_replace('/[^\+\d]+/', '', $input['phone']);
        }

        if (!empty($input['email']) && filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
            $email = $input['email'];
        }

        $registerCodes = (new RegisterCode)->whereIn(
            'field', ['phone', 'email']
        );

        $registerCodes = $registerCodes->whereIn('value', [$email, $phone]);

        $registerCodes = $registerCodes->get();
        $registerCode = null;

        if (count($registerCodes) > 0) {
            $registerCode = $registerCodes->filter(function ($registerCode) use ($code) {
                if ($registerCode->code == $code) {
                    return true;
                }
                return false;
            })->first();
        }

        return $registerCode;
    }
}