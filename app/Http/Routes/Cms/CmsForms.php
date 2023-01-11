<?php

use App\Utils\SpoofRoute;

Route::resource('forms', 'Cms\FormsController')->except('update');

SpoofRoute::action('forms', 'update');