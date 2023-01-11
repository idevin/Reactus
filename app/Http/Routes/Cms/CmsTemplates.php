<?php

use App\Utils\SpoofRoute;

Route::resource('templates', 'Cms\TemplatesController')->except('update');

SpoofRoute::action('templates', 'update');