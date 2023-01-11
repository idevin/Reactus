<?php

namespace App\Http\Requests;

class RegisterRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'login' => 'required|unique:mysqlu.users,login',
            'email' => 'required_if:phone,""|email_extended|max:100|unique:mysqlu.users,email',
            'g-recaptcha-response' => 'required_if:phone,""|captcha',
            'phone' => 'required_if:email,""|numeric|unique:mysqlu.users,phone',
            'password' => 'required|confirmed|min:6',
        ];
    }
}
