<?php

use App\Utils\SpoofRoute;

Route::resource('object_fields', 'Cms\ObjectFieldsController')->except('update');

SpoofRoute::action('object_fields', 'update');