<?php

use App\Utils\SpoofRoute;

Route::resource('section_users', 'Cms\SectionUsersController')->except('update');

SpoofRoute::action('section_users', 'update');