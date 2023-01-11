<?php

use App\Utils\SpoofRoute;

Route::resource('object_fields_relations', 'Cms\ObjectFieldsRelationsController')->except('update');

SpoofRoute::action('object_fields_relations', 'update');