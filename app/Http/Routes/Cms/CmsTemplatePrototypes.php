<?php

use App\Utils\SpoofRoute;

Route::resource('template_prototypes', 'Cms\TemplatePrototypesController')->except('update');

SpoofRoute::action('template_prototypes', 'update');
