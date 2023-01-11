<?php

use App\Utils\SpoofRoute;

Route::resource('site_sections', 'Cms\SiteSectionsController')->except('update');

SpoofRoute::action('site_sections', 'update');