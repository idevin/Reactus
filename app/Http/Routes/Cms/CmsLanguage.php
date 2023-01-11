<?php

use App\Utils\SpoofRoute;

Route::resource('language', 'Cms\LanguageController')->except('update');

SpoofRoute::action('language', 'update');