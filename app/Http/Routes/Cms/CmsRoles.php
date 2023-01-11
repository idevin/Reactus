<?php

use App\Utils\SpoofRoute;

Route::resource('roles', 'Cms\RolesController')->except('update');

SpoofRoute::action('roles', 'update');