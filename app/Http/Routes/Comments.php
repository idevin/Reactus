<?php

use App\Models\Comment;

Route::group(['prefix' => 'api', 'middleware' => ['api']], function () {

    Route::group(['prefix' => 'comments'], function () {
        Route::post('/add', 'Api\CommentsController@add')->name(Comment::class . '.add');
        Route::post('/delete', 'Api\CommentsController@delete')->name(Comment::class . '.delete');
        Route::post('/moderate', 'Api\CommentsController@moderate')->name(Comment::class . '.moderate_api');
        Route::post('/update', 'Api\CommentsController@update')->name(Comment::class . '.update');
        Route::get('/edit', 'Api\CommentsController@edit')->name(Comment::class . '.edit');
        Route::post('/batch_delete', 'Api\CommentsController@batchDelete')->name(Comment::class . '.batch_delete');
        Route::post('/batch_change_status', 'Api\CommentsController@batchChangeStatus')->name(Comment::class . '.batch_change_status');
        Route::post('/batch_move', 'Api\CommentsController@batchMove')->name(Comment::class . '.batch_move');
        Route::post('/pin', 'Api\CommentsController@pin')->name(Comment::class . '.pin');
        Route::post('/unpin', 'Api\CommentsController@unpin')->name(Comment::class . '.unpin');
        Route::post('/archive', 'Api\CommentsController@archive')->name(Comment::class . '.archive');
    });

});

Route::group(['prefix' => 'api'], function () {
    Route::get('/comments', 'Api\CommentsController@index')->name('api.comments.index');
});