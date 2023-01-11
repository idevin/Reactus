<?php


Route::get('/tag/{tag}', 'TagsController@show')
    ->name('tags.show');