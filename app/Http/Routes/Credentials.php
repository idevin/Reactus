<?php

Route::group(['middleware' => ['cookies', 'check_site', 'domain']], function () {

    Route::group(['prefix' => 'api/credentials'], function () {
        Route::get('/user/{id}', 'Api\CredentialsController@userById')->where('id', '[0-9]+');
        Route::get('/user', 'Api\CredentialsController@user');
    });

    Route::group(['prefix' => 'credentials', 'middleware' => ['cors', 'auth_server']], function () {
        Route::get('/token/{token}', 'CredentialsController@token')
            ->where('token', '[\.\$a-zA-Z0-9]+')
            ->name('api.credentials.token');

        Route::get('/login/{token}', 'CredentialsController@login')
            ->where('token', '[\.\$a-zA-Z0-9]+')->name('api.credentials.login_thematic');

        Route::get('/logout', 'CredentialsController@logout')
            ->name('api.credentials.logout');

    });

    Route::group(['prefix' => 'credentials', 'middleware' => ['cors']], function () {
        Route::get('/guest', 'CredentialsController@guest')->name('api.credentials.guest');
        Route::get('/check', 'CredentialsController@check')->name('api.credentials.check');
        Route::get('/erase_guest_cookie', 'CredentialsController@eraseGuestCookie')
            ->name('credentials.erase_guest_cookie');
        Route::get('/native_logout', 'CredentialsController@nativeLogout')->name('api.credentials.native_logout');
    });
});