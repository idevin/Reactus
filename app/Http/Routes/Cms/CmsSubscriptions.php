<?php

use App\Utils\SpoofRoute;

Route::resource('subscriptions', 'Cms\SubscriptionsController')->except('update');

SpoofRoute::action('subscriptions', 'update');
SpoofRoute::action('subscriptions', 'undelete', false, 'get');
SpoofRoute::action('subscriptions', 'destroyForever', false, 'delete');