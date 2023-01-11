<?php
Route::group(['prefix' => 'api/feedback', 'middleware' => ['api']], function () {
    Route::get('/', 'Api\FeedbackController@index');
    Route::post('/log', 'Api\FeedbackController@log');
});

Route::group(['prefix' => 'api/feedback'], function () {
    Route::get('/fields', 'Api\FeedbackController@fields');
});