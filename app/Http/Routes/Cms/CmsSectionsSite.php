<?php

use App\Utils\SpoofRoute;

Route::resource('sections_site', 'Cms\SectionsSiteController')->except('update');

SpoofRoute::action('sections_site', 'update');