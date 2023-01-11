<?php

Route::group(['prefix' => 'api', 'middleware' => ['api']], function () {

    Route::group(['prefix' => 'article_groups'], function () {

        Route::get('/search_group', 'Api\ArticleGroupsController@searchGroup');

        Route::get('/search_article', 'Api\ArticleGroupsController@searchArticle');

        Route::post('/delete_article', 'Api\ArticleGroupsController@deleteArticle');

        Route::post('/delete', 'Api\ArticleGroupsController@delete');

        Route::post('/create', 'Api\ArticleGroupsController@create');

        Route::post('/create_article', 'Api\ArticleGroupsController@createArticle');
    });
});