<?php

Route::group(['prefix' => '/api/rating', 'middleware' => ['api']], function () {

    Route::get('/article/{id}/get', 'Api\RatingController@getArticle')
        ->where('id', '[0-9]+')
        ->name('article.rating.get');

    Route::post('/article/{id}/set', 'Api\RatingController@setArticle')
        ->where('id', '[0-9]+')
        ->where('ratingValue', '[0-9]+')
        ->name('article.rating.set');

    Route::post('/comment/{id}/set', 'Api\RatingController@setComment')
        ->where('id', '[0-9]+')
        ->where('ratingValue', '[0-9]+')
        ->name('comment.rating.set');

    Route::post('/article/{id}/unvote', 'Api\RatingController@unvoteArticle')
        ->where('id', '[0-9]+')
        ->name('article.rating.unvote');

    Route::post('/comment/{id}/unvote', 'Api\RatingController@unvoteComment')
        ->where('id', '[0-9]+')
        ->name('comment.rating.unvote');

});
