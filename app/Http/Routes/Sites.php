<?php

Route::group(['prefix' => 'api/sites', 'middleware' => ['api']], function () {
    Route::post('/save', 'Api\SitesController@save');

    Route::post('/change_domain', 'Api\SitesController@changeDomain');

    Route::post('/update', 'Api\SitesController@update');

    Route::post('/transfer', 'Api\SitesController@transfer')->name('sites.transfer');

    Route::post('/destroy', 'Api\SitesController@destroy');

    Route::post('/update_settings', 'Api\SitesController@updateSettings');

    Route::post('/breadcrumbs/update', 'Api\SitesController@breadcrumbsUpdate');

    Route::get('/breadcrumbs/form', 'Api\SitesController@breadcrumbsForm');

    Route::get('/form', 'Api\SitesController@form');

    Route::get('/search', 'Api\SitesController@search');

    Route::post('/validate_domain', 'Api\SitesController@validateDomain');

    Route::post('/validate_site', 'Api\SitesController@validateSite');

    Route::get('/edit', 'Api\SitesController@edit');

    Route::post('/create', 'Api\SitesController@create');

    Route::post('/create_domain', 'Api\SitesController@createDomain');

    Route::post('/update_domain', 'Api\SitesController@updateDomain');

    Route::post('/filter_domains', 'Api\SitesController@filterDomains');

    Route::post('/options/save', 'Api\SitesController@optionsSave');
    Route::get('/options/form', 'Api\SitesController@optionsForm');

    Route::post('/menu/save', 'Api\SitesController@menuSave');
    Route::get('/menu/form', 'Api\SitesController@menuForm');

    Route::get('/v2/form', 'Api\SitesController@formV2');
    Route::post('/v2/update', 'Api\SitesController@updateV2');

    Route::post('/view/save', 'Api\SitesController@viewSave');
    Route::get('/view/form', 'Api\SitesController@viewForm');

    Route::post('/seo/save', 'Api\SitesController@seoSave');
    Route::get('/seo/form', 'Api\SitesController@seoForm');

    Route::post('/menu_options/save', 'Api\SitesController@menuOptionsSave');
    Route::get('/menu_options/form', 'Api\SitesController@menuOptionsForm');

    Route::post('/userbar_options/save', 'Api\SitesController@userbarOptionsSave');
    Route::get('/userbar_options/form', 'Api\SitesController@menuOptionsForm');

    Route::post('/feedback_settings/save', 'Api\SitesController@feedbackSettingsSave');
    Route::get('/feedback_settings/form', 'Api\SitesController@feedbackSettingsForm');

    Route::get('/contacts/form', 'Api\SitesController@contactsForm');
    Route::post('/contacts/save', 'Api\SitesController@contactsSave');

});

Route::group(['prefix' => 'api/sites'], function () {
    Route::get('/personal', 'Api\SitesController@personal');

    Route::get('/home', 'Api\SitesController@home');

    Route::get('/settings', 'Api\SitesController@settings')->name('api.sites.settings');

    Route::get('/slug', 'Api\SitesController@slug');

    Route::get('/', 'Api\SitesController@index');

    Route::get('/tree', 'Api\SitesController@tree');

    Route::get('/search_domain', 'Api\SitesController@searchDomain');

    Route::get('/check', 'Api\SitesController@check')->name('api.sites.check');

    Route::get('/theme', 'Api\SitesController@theme');
});
