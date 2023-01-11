<?php

Route::group(['middleware' => ['cors', 'auth_server']], function () {
    Route::get('/articles', 'ArticleController@index')
        ->name('article.index');

    Route::get('/article/{title?}-{id}.html', 'ArticleController@show')
        ->name('article.show')->where('id', '[0-9]+')
        ->where('title', '[A-Za-z0-9\-]+')
        ->where('article', '[A-Za-z0-9]+');
});

Route::group(['prefix' => 'api'], function () {
    Route::get('/articles', 'Api\ArticlesController@index')->name('api.articles');

    Route::get('/article/{title}-{id}.html', 'Api\ArticlesController@show')
        ->name('api.article.show')
        ->where('id', '[0-9]+')
        ->where('title', '[A-Za-z0-9\-]+');

    Route::get('/articles/sort', 'Api\ArticlesController@sort')->name('api.articles.sort');
});

Route::group(['prefix' => 'api', 'middleware' => ['api']], function () {

    Route::post('/articles/mass_delete', 'Api\ArticlesController@massDelete')->name('api.articles.mass_delete');
    Route::get('/articles/section', 'Api\ArticlesController@section')->name('api.articles.section');

    Route::group(['prefix' => 'articles'], function () {
        Route::get('/form', 'Api\ArticlesController@form')
            ->name('api.article.form');

        Route::post('/create', 'Api\ArticlesController@create')
            ->name('api.article.create');

        Route::post('/update', 'Api\ArticlesController@update')
            ->name('api.article.update');

        Route::post('/delete', 'Api\ArticlesController@delete')
            ->name('api.article.delete');

        Route::get('/search_group', 'Api\ArticlesController@searchGroup')
            ->name('api.article.search');

        Route::get('/slug', 'Api\ArticlesController@slug')
            ->name('api.article.slug');

        Route::post('/auto_save', 'Api\ArticlesController@autoSave')
            ->name('api.article.auto_save');

        Route::post('/cancel', 'Api\ArticlesController@cancel')
            ->name('api.article.cancel');

        Route::get('/revisions', 'Api\ArticlesController@revisions')
            ->name('api.article.revisions');

        Route::get('/show_revision', 'Api\ArticlesController@showRevision')
            ->name('api.article.show_revision');

        Route::post('/delete_language', 'Api\ArticlesController@deleteLanguage')
            ->name('api.article.delete_language');

        Route::post('/delete_article_group_article', 'Api\ArticlesController@deleteArticleFromGroup')
            ->name('api.article.delete_article_group_article');
    });
});