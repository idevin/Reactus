<?php

use App\Utils\SpoofRoute;

Route::resource('object_field_groups', 'Cms\ObjectFieldGroupsController')->except('update');
SpoofRoute::action('object_field_groups', 'updateTree', true);
SpoofRoute::action('object_field_groups', 'update');
