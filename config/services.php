<?php


use App\Models\User;

$mailRu = function () {
    $redirect = getSchema() . env('DEFAULT_DOMAIN') . '/social/mailru/callback';

    $domains = [
        'basual.ru' => [
            'client_id' => '758494',
            'client_secret' => '5969a5955f4a1ecacc714fea6b225b5b',
            'redirect' => $redirect
        ],
        env('DEFAULT_DOMAIN') => [
            'client_id' => '758495',
            'client_secret' => 'd9ca7e5cfdc8d3b1125f1d0c2d3e9824',
            'redirect' => $redirect
        ],
        'reactus.net' => [
            'client_id' => '759629',
            'client_secret' => '61ac9d92760da553eccbb48f04a45ee5',
            'redirect' => $redirect
        ]
    ];

    return isset($domains[env('DEFAULT_DOMAIN')]) ? $domains[env('DEFAULT_DOMAIN')] : null;
};

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'mandrill' => [
        'secret' => env('MANDRILL_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'stripe' => [
        'model' => User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    'vkontakte' => [
        'client_id' => env('SOCIAL_VK_CLIENT_ID'),
        'client_secret' => env('SOCIAL_VK_CLIENT_SECRET'),
        'redirect' => getSchema() . env('DEFAULT_DOMAIN') . '/social/vk/callback',
        'response_type' => 'code'
    ],
    'google' => [
        'client_id' => env('SOCIAL_GOOGLE_CLIENT_ID'),
        'client_secret' => env('SOCIAL_GOOGLE_CLIENT_SECRET'),
        'redirect' => getSchema() . env('DEFAULT_DOMAIN') . '/social/google/callback',
    ],
    'odnoklassniki' => [
        'client_id' => env('SOCIAL_OK_CLIENT_ID'),
        'client_secret' => env('SOCIAL_OK_CLIENT_SECRET'),
        'client_public' => env('SOCIAL_OK_CLIENT_PUBLIC'),
        'redirect' => getSchema() . env('DEFAULT_DOMAIN') . '/social/ok/callback',
    ],
    'facebook' => [
        'client_id' => env('SOCIAL_FACEBOOK_CLIENT_ID'),
        'client_secret' => env('SOCIAL_FACEBOOK_CLIENT_SECRET'),
        'redirect' => getSchema() . env('DEFAULT_DOMAIN') . '/social/facebook/callback',
    ],
    'twitter' => [
        'client_id' => env('SOCIAL_TWITTER_CLIENT_ID'),
        'client_secret' => env('SOCIAL_TWITTER_CLIENT_SECRET'),
        'redirect' => getSchema() . env('DEFAULT_DOMAIN') . '/social/twitter/callback'
    ],
    'instagram' => [
        'client_id' => env('SOCIAL_INSTAGRAM_CLIENT_ID'),
        'client_secret' => env('SOCIAL_INSTAGRAM_CLIENT_SECRET'),
        'redirect' => getSchema() . env('DEFAULT_DOMAIN') . '/social/instagram/callback'
    ],
    'yandex' => [
        'client_id' => env('SOCIAL_YANDEX_CLIENT_ID'),
        'client_secret' => env('SOCIAL_YANDEX_CLIENT_SECRET'),
        'redirect' => getSchema() . env('DEFAULT_DOMAIN') . '/social/yandex/callback'
    ],
    'linkedin' => [
        'client_id' => env('SOCIAL_LINKEDIN_CLIENT_ID'),
        'client_secret' => env('SOCIAL_LINKEDIN_CLIENT_SECRET'),
        'redirect' => getSchema() . env('DEFAULT_DOMAIN') . '/social/linkedin/callback'
    ],
    'mailru' => $mailRu()
];
