<?php

use App\Utils\SpoofRoute;

Route::resource('currency', 'Cms\CurrencyController')->except('update');

SpoofRoute::action('currency', 'update');