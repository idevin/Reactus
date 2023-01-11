<?php

use App\Utils\SpoofRoute;

Route::resource('activities', 'Cms\ActivitiesController');
SpoofRoute::action('activities', 'searchAuthor', true);

Route::resource('activity_languages', 'Cms\ActivityLanguagesController')->except('update');
SpoofRoute::action('activity_languages', 'update');