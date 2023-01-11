<?php

Route::group(['middleware' => ['cors', 'auth_server']], function () {
    Route::get('/page/{slug?}-{id}.html', 'PagesController@show')
        ->where('id', '[0-9]+')->where('slug', '[A-Za-z0-9\-]+')->name('page.show');

    Route::group(['prefix' => '/api/pages'], function () {
        Route::get('/home', 'Api\PagesController@home');
        Route::get('/settings', 'Api\PagesController@settings');
    });
});

/**
 * API AUTH REQUIRED
 */
Route::group(['prefix' => 'api/pages', 'middleware' => ['api']], function () {

    Route::get('/{slug?}-{id}.html', 'PagesController@show')
        ->where('id', '[0-9]+')->where('slug', '[A-Za-z0-9\-]+');

    Route::get('', 'Api\PagesController@index');
    Route::post('/create', 'Api\PagesController@create');
    Route::post('/update', 'Api\PagesController@update');
    Route::post('/active', 'Api\PagesController@active');
    Route::post('/edit_mode', 'Api\PagesController@editMode');
    Route::get('/form', 'Api\PagesController@form');
    Route::post('/delete', 'Api\PagesController@delete');
    Route::post('/undo', 'Api\PagesController@undo');

    Route::group(['prefix' => 'stroke', 'middleware' => ['api']], function () {
        Route::post('/sort', 'Api\PageStrokesController@sort');
        Route::post('/create', 'Api\PageStrokesController@create');
        Route::post('/update', 'Api\PageStrokesController@update');
        Route::post('/delete', 'Api\PageStrokesController@delete');
        Route::post('/active', 'Api\PageStrokesController@active');

        Route::group(['prefix' => 'modules'], function () {
            Route::post('/sort', 'Api\PageStrokeModulesController@sort');
            Route::post('/create', 'Api\PageStrokeModulesController@create');
            Route::post('/update', 'Api\PageStrokeModulesController@update');
            Route::post('/delete', 'Api\PageStrokeModulesController@delete');
            Route::get('/form', 'Api\PageStrokeModulesController@form');
            Route::post('/update_content_options', 'Api\PageStrokeModulesController@updateContentOptions');
        });

        Route::group(['prefix' => 'blocks'], function () {
            Route::post('/create', 'Api\PageStrokeBlocksController@create');
            Route::post('/update', 'Api\PageStrokeBlocksController@update');
            Route::post('/sort', 'Api\PageStrokeBlocksController@sort');
        });
    });
});