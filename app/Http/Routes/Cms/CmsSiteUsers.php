<?php

use App\Utils\SpoofRoute;

Route::resource('site_users', 'Cms\SiteUsersController')->except('update');

SpoofRoute::action('site_users', 'update');