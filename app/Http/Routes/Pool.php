<?php

Route::group(['prefix' => 'api/pool', 'middleware' => 'api'], function () {
    Route::get('/index', 'Api\ModerationPoolController@index')
        ->name('moderate.index');

    Route::post('/answer', 'Api\ModerationPoolController@answer')
        ->name('moderate.answer');
});