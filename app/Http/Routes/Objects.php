<?php
Route::get('/catalogs', 'ObjectsController@catalogs')->name('objects.catalogs');

Route::get('/catalogs/{url}-{id}', 'ObjectsController@catalogView')
    ->where('url', '[A-Za-z0-9\-]+')
    ->where('id', '[0-9]+')
    ->name('objects.catalog.view');

Route::get('/card/{name}-{id}.html', 'ObjectsController@card')
    ->where('id', '[0-9]+')
    ->where('name', '[A-Za-z0-9\-]+')
    ->name('objects.view_card');

Route::get('/catalog', 'ObjectsController@catalog')->name('objects.catalog');

Route::get('/catalog/{url}-{id}', 'ObjectsController@catalogFrontView')
    ->where('url', '[A-Za-z0-9\-]+')
    ->where('id', '[0-9]+')
    ->name('objects.catalog.front.view');

Route::group(['prefix' => 'api/objects', 'middleware' => ['api']], function () {

    Route::get('/list', 'Api\Catalog\ObjectsController@list');
});

Route::group(['prefix' => 'api/objects'], function () {

    Route::get('/get_data', 'Api\Catalog\ObjectsController@getData');

    Route::get('/catalog', 'Api\Catalog\ObjectsController@catalog');

    Route::get('/filter', 'Api\Catalog\ObjectsController@filter');

    Route::post('/copy_card', 'Api\Catalog\ObjectsController@copyCard');

    Route::post('/search', 'Api\Catalog\ObjectsController@search');

    Route::post('/search_inside', 'Api\Catalog\ObjectsController@searchInside');

    Route::get('/search_card', 'Api\Catalog\ObjectsController@searchCard')
        ->name('search.card');

    Route::get('/view_card/{id}', 'Api\Catalog\ObjectsController@viewCard')
        ->where('id', '[0-9]+');

    Route::get('/related/{id}', 'Api\Catalog\ObjectsController@related')
        ->where('id', '[0-9]+');
});

Route::group(['prefix' => 'api/objects', 'middleware' => ['api']], function () {
    Route::post('/save', 'Api\Catalog\ObjectsController@save')
        ->name('api.objects.save');

    Route::post('/update', 'Api\Catalog\ObjectsController@update');

    Route::post('/create_catalog', 'Api\Catalog\ObjectsController@createCatalog');

    Route::get('/form/{oId}', 'Api\Catalog\ObjectsController@form')
        ->where('oId', '[\d]+');

    Route::post('/save_form/{oId}', 'Api\Catalog\ObjectsController@saveForm')
        ->where('oId', '[\d]+');

    Route::post('/update', 'Api\Catalog\ObjectsController@update');

    Route::post('/delete/{oId}', 'Api\Catalog\ObjectsController@delete')
        ->where('oId', '[\d]+');

    Route::get('/', 'Api\Catalog\ObjectsController@index');
    Route::get('/data', 'Api\Catalog\ObjectsController@data');
    Route::get('/cards', 'Api\Catalog\ObjectsController@cards');
    Route::get('/catalogs', 'Api\Catalog\ObjectsController@catalogs');
    Route::post('/catalogs/delete', 'Api\Catalog\ObjectsController@deleteCatalog');
    Route::post('/copy_card', 'Api\Catalog\ObjectsController@copyCard');

    Route::get('/catalogs/{url}-{id}', 'Api\Catalog\ObjectsController@catalogView')
        ->where('url', '[A-Za-z0-9\-]+')
        ->name('api.objects.catalog.view');
});

Route::group(['prefix' => 'api/catalog', 'middleware' => ['api']], function () {

    Route::group(['prefix' => '/category', 'middleware' => ['api']], function () {
        Route::get('/', 'Api\Catalog\CategoryController@index');
        Route::post('/create', 'Api\Catalog\CategoryController@create');
        Route::post('/update', 'Api\Catalog\CategoryController@update');
        Route::post('/delete', 'Api\Catalog\CategoryController@delete');
    });
});