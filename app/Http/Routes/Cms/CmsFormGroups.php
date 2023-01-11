<?php

use App\Utils\SpoofRoute;

Route::resource('form_groups', 'Cms\FormGroupsController')->except('update');

SpoofRoute::action('form_groups', 'update');

SpoofRoute::action('form_groups', 'updateTree', true);