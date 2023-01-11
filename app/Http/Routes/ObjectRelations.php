<?php

Route::group(['prefix' => 'api/object_relations', 'middleware' => ['api']], function () {
    Route::get('/list', 'Api\Catalog\ObjectsRelationsController@cardsList');
    Route::get('/get_card', 'Api\Catalog\ObjectsRelationsController@getCard');
    Route::post('/connect', 'Api\Catalog\ObjectsRelationsController@connect');
    Route::post('/disconnect', 'Api\Catalog\ObjectsRelationsController@disconnect');
});