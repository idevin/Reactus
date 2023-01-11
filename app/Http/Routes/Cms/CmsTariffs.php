<?php
Route::group(['prefix' => 'tariffs'], function () {

    Route::get('/', 'Cms\TariffsController@index')
        ->name('cms.billing.tariffs.index');

    Route::get('/create', 'Cms\TariffsController@create')
        ->name('cms.billing.tariffs.create');

    Route::get('/{tariff_id}/edit', 'Cms\TariffsController@edit')
        ->name('cms.billing.tariffs.edit')
        ->where('tariff_id', '\d+');

    Route::post('/{tariff_id}/update', 'Cms\TariffsController@update')
        ->name('cms.billing.tariffs.update')
        ->where('tariff_id', '\d+');

    Route::delete('/{tariff_id}/destroy', 'Cms\TariffsController@delete')
        ->name('cms.billing.tariffs.destroy')
        ->where('tariff_id', '\d+');

    Route::post('/store', 'Cms\TariffsController@store')
        ->name('cms.billing.tariffs.store');
});