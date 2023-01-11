<?php

Route::group(['prefix' => 'api/time'], function () {

    Route::get('/utc/{utc}', 'Api\TimeController@utc')
        ->name('time.utc')
        ->where('utc', '[0-9a-zA-z\+\-]+');

});