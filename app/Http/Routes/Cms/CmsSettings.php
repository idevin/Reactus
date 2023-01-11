<?php

use App\Utils\SpoofRoute;

Route::resource('settings', 'Cms\SettingsController')->except('update');

SpoofRoute::action('settings', 'update');