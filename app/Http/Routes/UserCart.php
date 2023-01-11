<?php

Route::group(['prefix' => 'api/cart', 'middleware' => ['api']], function () {
    Route::get('/', 'Api\UserCartController@index')->name('api.cart');

    Route::post('/add', 'Api\UserCartController@add')->name('api.cart.add');
    Route::post('/update', 'Api\UserCartController@update')->name('api.cart.update');
    Route::post('/delete', 'Api\UserCartController@delete')->name('api.cart.delete');
    Route::post('/checkout', 'Api\UserCartController@checkout')->name('api.cart.checkout');
});