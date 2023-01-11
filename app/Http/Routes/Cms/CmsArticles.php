<?php

use App\Utils\SpoofRoute;

Route::resource('articles', 'Cms\ArticlesController')->except('update');

SpoofRoute::action('articles', 'undelete', false, 'get');
SpoofRoute::action('articles', 'destroyForever', false, 'delete');
SpoofRoute::action('articles', 'massDelete', true);
SpoofRoute::action('articles', 'restore', true);
SpoofRoute::action('articles', 'massUpdateAuthor', true);
SpoofRoute::action('articles', 'changeSection', true);
SpoofRoute::action('articles', 'searchAuthor', true);
SpoofRoute::action('articles', 'update');