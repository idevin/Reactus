<?php
Route::group(['prefix' => 'services'], function () {

    Route::get('/', 'Cms\ServicesController@index')
        ->name('cms.billing.services.index');

    Route::get('/create', 'Cms\ServicesController@create')
        ->name('cms.billing.services.create');

    Route::post('/store', 'Cms\ServicesController@store')
        ->name('cms.billing.services.store');

    Route::get('/{services}/edit', 'Cms\ServicesController@edit')
        ->name('cms.billing.services.edit')
        ->where('services', '\d+');

    Route::post('/{services}/update', 'Cms\ServicesController@update')
        ->name('cms.billing.services.update')
        ->where('services', '\d+');

    Route::delete('/{services}/destroy', 'Cms\ServicesController@delete')
        ->name('cms.billing.services.destroy')
        ->where('services', '\d+');
});