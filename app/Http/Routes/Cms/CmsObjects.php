<?php

use App\Utils\SpoofRoute;

Route::get('/objects/relations', 'Cms\ObjectsController@relations')
    ->name('objects.relations');

Route::resource('objects', 'Cms\ObjectsController')->except('update');

SpoofRoute::action('objects', 'massDelete', true);
SpoofRoute::action('objects', 'update');
SpoofRoute::action('objects', 'updateNode', true);