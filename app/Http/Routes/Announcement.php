<?php

Route::group(['prefix' => 'api', 'middleware' => ['api']], function () {
    Route::group(['prefix' => 'announcement'], function () {
        Route::get('/form', 'Api\AnnouncementController@form');
        Route::post('/create', 'Api\AnnouncementController@create');
        Route::post('/update', 'Api\AnnouncementController@update');
        Route::post('/delete', 'Api\AnnouncementController@delete');
        Route::get('/search', 'Api\AnnouncementController@search')->middleware('throttle:80,0.5');
    });
});