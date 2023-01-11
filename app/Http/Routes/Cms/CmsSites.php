<?php

use App\Utils\SpoofRoute;

Route::resource('sites', 'Cms\SitesController')->except('update');

SpoofRoute::action('sites', 'update');
SpoofRoute::action('sites', 'updateTree', true);
SpoofRoute::action('sites', 'undelete', false, 'get');
SpoofRoute::action('sites', 'destroyForever', false, 'delete');
SpoofRoute::action('sites', 'destroyCascade', false, 'delete');