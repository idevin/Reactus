<?php

use App\Utils\SpoofRoute;

Route::resource('complains', 'Cms\ComplainsController')->except('update');

SpoofRoute::action('complains', 'update');