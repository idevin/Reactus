<?php

Route::group(['prefix' => 'api', 'middleware' => ['api']], function () {

    Route::get('/templates', 'Api\TemplatesController@index')
        ->name('api.templates.index');

    Route::get('/templates/form', 'Api\TemplatesController@form')
        ->name('api.templates.form');

    Route::post('/templates/update', 'Api\TemplatesController@update')
        ->name('api.templates.update');
});