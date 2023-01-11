<?php

Route::post('/login', 'Api\AuthController@login')->name('api.login');
Route::get('/logout', 'Api\AuthController@logout')->name('api.logout');
Route::post('/users/destroy', 'Api\UsersController@destroy')->name('api.destroy');

Route::post('/reset-password', 'Api\AuthController@resetPassword')
    ->name('api.reset-password');

Route::group(['prefix' => 'forgot'], function () {
    Route::post('/send-code', 'Api\ForgotController@sendCode');
    Route::post('/change-password', 'Api\ForgotController@forgot');
    Route::post('/check-code', 'Api\ForgotController@checkCode');
    Route::post('/check-login', 'Api\ForgotController@checkLogin');
});

Route::group(['prefix' => 'register'], function () {
    Route::post('/check-login', 'Api\RegisterController@checkLogin');
    Route::post('/check-email', 'Api\RegisterController@checkEmail');
    Route::post('/check-phone', 'Api\RegisterController@checkPhone');
    Route::post('/send-code', 'Api\RegisterController@sendCode');
    Route::post('/check-code', 'Api\RegisterController@checkCode');
});
