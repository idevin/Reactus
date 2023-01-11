<?php


$middleware = ['web', 'session', 'cors', 'cookies'];
$providers = [
    'vk', 'google', 'ok', 'twitter', 'instagram', 'yandex', 'linkedin', 'mailru', 'facebook'
];

array_map(function ($provider) use ($middleware) {
    Route::group(['prefix' => 'social', 'middleware' => $middleware], function () use ($provider) {
        Route::get('/' . $provider, 'Social\\' . ucfirst($provider) . 'Controller@index');
        Route::get('/' . $provider . '/callback', 'Social\\' . ucfirst($provider) . 'Controller@callback');
    });
}, $providers);