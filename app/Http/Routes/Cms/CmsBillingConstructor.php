<?php
Route::group(['prefix' => 'constructor'], function () {

    Route::get('/', 'Cms\BillingConstructorController@index')
        ->name('cms.billing.constructor.index');

    Route::get('/create', 'Cms\BillingConstructorController@create')
        ->name('cms.billing.constructor.create');

    Route::get('/{constructor}/edit', 'Cms\BillingConstructorController@edit')
        ->name('cms.billing.constructor.edit')
        ->where('constructor', '\d+');

    Route::post('/{constructor}/update', 'Cms\BillingConstructorController@update')
        ->name('cms.billing.constructor.update')
        ->where('constructor', '\d+');

    Route::post('/store', 'Cms\BillingConstructorController@store')
        ->name('cms.billing.constructor.store')
        ->where('constructor', '\d+');

    Route::delete('/{constructor}/destroy', 'Cms\BillingConstructorController@delete')
        ->name('cms.billing.constructor.destroy')
        ->where('constructor', '\d+');
});