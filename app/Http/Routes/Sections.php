<?php


Route::group(['middleware' => ['cors', 'auth_server']], function () {
    Route::get('/sections', 'SectionController@index')
        ->name('section.index');

    Route::get('/section/{section}-{id}', 'SectionController@show')
        ->name('section.show')
        ->where('id', '[0-9]+')
        ->where('section', '[a-z0-9\/\-]+');
});

Route::group(['prefix' => 'api', 'middleware' => ['cookies', 'check_site', 'domain', 'api']], function () {

    Route::group(['prefix' => 'sections'], function () {

        Route::get('/slug', 'Api\SectionsController@slug')
            ->name('api.section.slug');

        Route::post('/create', 'Api\SectionsController@create')
            ->name('api.section.create');

        Route::post('/delete', 'Api\SectionsController@delete')
            ->where('id', '\d+')
            ->name('api.section.delete');

        Route::get('/form', 'Api\SectionsController@form')
            ->name('api.section.form');

        Route::post('/update', 'Api\SectionsController@update')
            ->name('api.section.update');

        Route::get('/site', 'Api\SectionsController@site')
            ->name('api.section.hide');

        Route::post('/mass_delete', 'Api\SectionsController@massDelete')
            ->name('api.section.mass_delete');

        Route::get('/section', 'Api\SectionsController@section')
            ->name('api.section.section');
    });
});

Route::group(['prefix' => 'api/sections'], function () {

    Route::get('/', 'Api\SectionsController@index')
        ->name('api.section.index');

    Route::get('/sort', 'Api\SectionsController@sort')
        ->name('api.sections.sort');
});

Route::group(['prefix' => 'api/section'], function () {
    Route::get('/{section}-{id}', 'Api\SectionsController@show')
        ->where('id', '[0-9]+')
        ->where('section', '[a-z0-9\/\-]+')
        ->name('api.section.show');
});

