<?php

Route::group(['prefix' => 'api', 'middleware' => ['api']], function () {

    Route::get('/colors/edit', 'Api\ColorsController@edit')
        ->name('api.colors.form');

    Route::post('/colors/update', 'Api\ColorsController@update')
        ->name('api.colors.update');

    Route::post('/colors/create', 'Api\ColorsController@create')
        ->name('api.colors.create');

    Route::post('/colors/delete', 'Api\ColorsController@delete')
        ->name('api.colors.delete');
});