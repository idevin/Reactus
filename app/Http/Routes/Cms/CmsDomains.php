<?php

use App\Utils\SpoofRoute;

Route::resource('domains', 'Cms\DomainsController')->except('update');

SpoofRoute::action('domains', 'update');