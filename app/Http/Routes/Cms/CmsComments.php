<?php

use App\Utils\SpoofRoute;

Route::resource('comments', 'Cms\CommentsController')->except('update');

SpoofRoute::action('comments', 'update');