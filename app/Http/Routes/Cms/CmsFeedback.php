<?php

use App\Utils\SpoofRoute;

Route::resource('feedback', 'Cms\FeedbackController')->except('update');

SpoofRoute::action('feedback', 'update');