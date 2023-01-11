<?php

Route::group(['prefix' => 'api'], function () {

    Route::group(['prefix' => 'contacts'], function () {
        Route::get('/', 'Api\ContactsController@index');
    });
});