<?php
Route::group(['prefix' => 'discounts'], function () {

    Route::get('/', 'Cms\DiscountsController@index')
        ->name('cms.billing.discounts.index');

    Route::get('/create', 'Cms\DiscountsController@create')
        ->name('cms.billing.discounts.create');

    Route::post('/store', 'Cms\DiscountsController@store')
        ->name('cms.billing.discounts.store');

    Route::get('/{services}/edit', 'Cms\DiscountsController@edit')
        ->name('cms.billing.discounts.edit')
        ->where('services', '\d+');

    Route::post('/{services}/update', 'Cms\DiscountsController@update')
        ->name('cms.billing.discounts.update')
        ->where('services', '\d+');

    Route::delete('/{services}/destroy', 'Cms\DiscountsController@delete')
        ->name('cms.billing.discounts.destroy')
        ->where('services', '\d+');
});