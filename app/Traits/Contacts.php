<?php

namespace App\Traits;

use Validator;

trait Contacts
{
    public static function createContactsValidator($data, $except = [], $customErrors = [], $customMessages = [])
    {
        $default = [
            'position' => 'required',
            'module_id' => 'required',
            'phone' => 'array'
        ];

        $messages = [
            'position.required' => 'Не задана позиция блока',
            'module_id.required' => 'Не задан ID модуля',
            'phone.array' => 'Не задан массив телефонов'
        ];

        return Utils::makeValidator($data, $messages, $customMessages, $default, $customErrors, $except);
    }

    public static function contactsData($data): array
    {
        $phone = $data['phone'] ?? null;
        $email = $data['email'] ?? null;
        $address = $data['address'] ?? null;
        $workHours = $data['work_hours'] ?? null;
        $copyright = $data['copyright'] ?? null;
        $coords = $data['coords'] ?? null;
        $jivosite = $data['jivosite'] ?? null;
        $showInPages = $data['show_in_pages'] ?? 0;
        $showInAboutPage = $data['show_in_about_page'] ?? 0;
        $text = $data['text'] ?? 0;
        $feedbackId = $data['feedback_id'] ?? null;

        $facebookUrl = $data['facebook_url'] ?? null;
        $vkUrl = $data['vk_url'] ?? null;
        $twitterUrl = $data['twitter_url'] ?? null;
        $okUrl = $data['ok_url'] ?? null;
        $instagramUrl = $data['instagram_url'] ?? null;
        $templateId = $data['template_id'] ?? null;
        $recaptcha = $data['recaptcha'] ?? null;

        return [
            'phone' => $phone,
            'email' => $email,
            'address' => $address,
            'work_hours' => $workHours,
            'copyright' => $copyright,
            'jivosite' => $jivosite,
            'show_in_pages' => $showInPages,
            'show_in_about_page' => $showInAboutPage,
            'text' => $text,
            'feedback_id' => $feedbackId,
            'coords' => $coords,
            'facebook_url' => $facebookUrl,
            'vk_url' => $vkUrl,
            'twitter_url' => $twitterUrl,
            'ok_url' => $okUrl,
            'instagram_url' => $instagramUrl,
            'template_id' => $templateId,
            'recaptcha' => $recaptcha
        ];
    }
}