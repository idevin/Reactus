<?php
Route::group(['prefix' => 'service_options'], function () {

    Route::get('/', 'Cms\ServiceOptionsController@index')
        ->name('cms.billing.service_options.index');

    Route::get('/create', 'Cms\ServiceOptionsController@create')
        ->name('cms.billing.service_options.create');

    Route::post('/store', 'Cms\ServiceOptionsController@store')
        ->name('cms.billing.service_options.store');

    Route::get('/{service_options}/edit', 'Cms\ServiceOptionsController@edit')
        ->name('cms.billing.service_options.edit')
        ->where('services', '\d+');

    Route::post('/{service_options}/update', 'Cms\ServiceOptionsController@update')
        ->name('cms.billing.service_options.update')
        ->where('services', '\d+');

    Route::delete('/{service_options}/destroy', 'Cms\ServiceOptionsController@delete')
        ->name('cms.billing.service_options.destroy')
        ->where('services', '\d+');
});