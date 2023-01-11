<?php

Route::get('/section/{section}-{id}/trash', 'TrashBinController@show')
    ->where('id', '[0-9]+')
    ->where('section', '[a-z0-9\/\-]+')
    ->name('section.show_trash');

Route::group(['prefix' => 'api', 'middleware' => ['api']], function () {

    Route::get('/section/{section}-{id}/trash', 'Api\TrashBinController@showBySection')
        ->where('id', '[0-9]+')
        ->where('section', '[a-z0-9\/\-]+')
        ->name('api.trash.show_with_section');

    Route::group(['prefix' => 'trash'], function () {
        Route::get('/', 'Api\TrashBinController@index')
            ->name('api.trash.index');

        Route::post('/sections/mass_delete', 'Api\TrashBinController@massDeleteSections');
        Route::post('/articles/mass_delete', 'Api\TrashBinController@massDeleteArticles');
        Route::post('/delete_forever', 'Api\TrashBinController@deleteForever');

        Route::post('/undelete', 'Api\TrashBinController@undelete');

//        Route::get('/show/{id}', 'Api\TrashBinController@show')->where('id', '\d+');
    });

});