<?php

use App\Utils\SpoofRoute;

Route::resource('thematic', 'Cms\ThematicController')->except('update');

SpoofRoute::action('thematic', 'update');