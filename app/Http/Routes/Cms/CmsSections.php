<?php

use App\Utils\SpoofRoute;

\Route::resource('sections', 'Cms\SectionsController')->except('update');

SpoofRoute::action('sections', 'massDelete', true);
SpoofRoute::action('sections', 'updateTree', true);
SpoofRoute::action('sections', 'update');
SpoofRoute::action('sections', 'undelete', false, 'get');
SpoofRoute::action('sections', 'destroyForever', false, 'delete');
