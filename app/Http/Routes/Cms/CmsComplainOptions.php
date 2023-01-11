<?php

use App\Utils\SpoofRoute;

Route::resource('complain_options', 'Cms\ComplainOptionsController')->except('update');

SpoofRoute::action('complain_options', 'update');
SpoofRoute::action('complain_options', 'updateTree', true);