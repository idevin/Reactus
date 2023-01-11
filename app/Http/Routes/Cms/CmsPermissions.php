<?php

use App\Utils\SpoofRoute;

Route::resource('permissions', 'Cms\PermissionsController')->except('update');

SpoofRoute::action('permissions', 'update');