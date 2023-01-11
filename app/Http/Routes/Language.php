<?php

Route::group(['prefix' => 'api', 'middleware' => ['api']], function () {

    Route::get('/language/form', 'Api\LanguageController@form');

    Route::post('/language/add_domain', 'Api\LanguageController@addDomain');

    Route::post('/language/update', 'Api\LanguageController@update');

    Route::post('/language/add', 'Api\LanguageController@add');
});