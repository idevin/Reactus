<?php

Route::group(['prefix' => 'api', 'middleware' => 'api'], function () {

    Route::group(['prefix' => 'robots'], function () {

        Route::get('/show', 'Api\RobotoEditor@show');
        Route::post('/edit', 'Api\RobotoEditor@update');
    });
});