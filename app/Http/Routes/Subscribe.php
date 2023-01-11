<?php

Route::group(['prefix' => 'api'], function () {
    Route::group(['prefix' => 'subscribe'], function () {
    });
});

Route::group(['prefix' => 'api', 'middleware' => ['api']], function () {

    Route::get('/subscriptions', 'Api\SubscribeController@index')->name('api.subscribe.subscriptions');

    Route::group(['prefix' => 'subscribe'], function () {

        Route::post('/section', 'Api\SubscribeController@section')->name('api.subscribe.section');
        Route::post('/article', 'Api\SubscribeController@article')->name('api.subscribe.article');
        Route::post('/user', 'Api\SubscribeController@user')->name('api.subscribe.user');

    });

    Route::group(['prefix' => 'unsubscribe'], function () {

        Route::post('/section', 'Api\SubscribeController@unsubscribeSection')->name('api.unsubscribe.section');
        Route::post('/article', 'Api\SubscribeController@unsubscribeArticle')->name('api.unsubscribe.article');
        Route::post('/user', 'Api\SubscribeController@unsubscribeUser')->name('api.unsubscribe.user');

    });
});