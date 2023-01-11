<?php

Route::group(['prefix' => 'settings'], function () {
    Route::get('/site', 'SettingsController@site')->name('site.settings');
    Route::post('/site/update', 'SettingsController@siteUpdate')->name('site.settings.update');
});