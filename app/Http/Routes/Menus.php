<?php
Route::group(['prefix' => 'api/menu'], function () {

    Route::get('/', 'Api\MenuController@index')->name('api.menu.index');

    Route::post('/update', 'Api\MenuController@update')->middleware('api')->name('menu.update_item');

    Route::post('/sort', 'Api\MenuController@sort')->middleware('api')->name('menu.sort');

    Route::post('/set_visible', 'Api\MenuController@setVisible')->middleware('api')->name('menu.set_visible');

    Route::get('/form', 'Api\MenuController@form')->middleware('api')->name('menu.form');

    Route::post('/create', 'Api\MenuController@create')->middleware('api')->name('menu.create');

    Route::post('/delete', 'Api\MenuController@delete')->middleware('api')->name('menu.delete');
});