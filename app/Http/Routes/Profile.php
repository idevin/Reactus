<?php

Route::group(['prefix' => 'api', 'middleware' => ['api']], function () {

    Route::group(['prefix' => 'profile'], function () {

        Route::post('/search/article', 'Api\ProfileController@searchArticle')
            ->name('api.profile.search_article');

        Route::post('/save_status', 'Api\ProfileController@saveStatus')
            ->name('api.profile.save_status')->middleware('user_matches');

        Route::post('/save_images', 'Api\ProfileController@saveImages')
            ->name('api.profile.save_images')->middleware('user_matches');

        Route::post('/delete_images', 'Api\ProfileController@deleteImages')
            ->name('api.profile.delete_images')->middleware('user_matches');

        Route::post('/change_domain', 'Api\ProfileController@changeDomain')
            ->name('api.profile.change_domain')->middleware('user_matches');

        Route::post('/change_username', 'Api\ProfileController@changeUsername')
            ->name('api.profile.change_username')->middleware('user_matches');
    });
});

Route::group(['prefix' => 'api'], function () {

    Route::group(['prefix' => 'profile'], function () {

        Route::get('/statuses', 'Api\ProfileController@statuses')
            ->name('api.profile.statuses');

        Route::get('/info', 'Api\ProfileController@info')
            ->name('api.profile.info');

        Route::get('/fields', 'Api\ProfileController@fields')
            ->name('api.profile.fields');

        Route::get('/images', 'Api\ProfileController@images')
            ->name('api.profile.images');
    });
});