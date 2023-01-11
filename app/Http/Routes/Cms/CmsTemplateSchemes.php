<?php

use App\Utils\SpoofRoute;

Route::resource('template_schemes', 'Cms\TemplateSchemesController')->except('update');

SpoofRoute::action('template_schemes', 'update');