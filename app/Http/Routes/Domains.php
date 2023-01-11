<?php

Route::group(['prefix' => 'api/domains'], function () {
    Route::any('/personal', 'Api\DomainsController@personal')
        ->name('api.domains.personal');
});

Route::group(['prefix' => 'api/domains', 'middleware' => ['api']], function () {
    Route::post('/thematic', 'Api\DomainsController@thematic')
        ->name('api.sites.thematic');

    Route::post('/check_subdomain', 'Api\DomainsController@checkSubdomain')
        ->name('api.sites.check_subdomain');

    Route::post('/change_user', 'Api\DomainsController@changeUser')
        ->name('api.sites.change_user');

    Route::get('/check', 'Api\DomainsController@check')
        ->name('api.domains.check');
});