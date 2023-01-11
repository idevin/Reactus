<?php

use App\Utils\SpoofRoute;

Route::resource('pool', 'Cms\PoolController')->except('update');

SpoofRoute::action('pool', 'update');

Route::get('/pool/approve_complain/{id}', 'Cms\PoolController@approveComplain')
    ->name('cms.pool.approve_complain')
    ->where('id', '\d+');

Route::get('/pool', 'Cms\PoolController@index')
    ->name('cms.pool.index');

Route::get('/pool/deny_complain/{id}', 'Cms\PoolController@denyComplain')
    ->name('cms.pool.deny_complain')
    ->where('id', '\d+');

Route::get('/pool/delete_answer/{id}', 'Cms\PoolController@deleteAnswer')
    ->where('id', '\d+')
    ->name('cms.pool.delete_answer');

Route::any('/pool/approve/{object}/{id}', 'Cms\PoolController@approve')
    ->where('object', '\w+')
    ->where('id', '\d+')
    ->name('cms.pool.approve');

Route::any('/pool/approve_transfer/{object}/{id}', 'Cms\PoolController@approveTransfer')
    ->where('object', '\w+')
    ->where('id', '\d+')
    ->name('cms.pool.approve_transfer');

Route::any('/pool/deny_transfer/{object}/{id}', 'Cms\PoolController@denyTransfer')
    ->where('object', '\w+')
    ->where('id', '\d+')
    ->name('cms.pool.deny_transfer');

Route::any('/pool/deny_section_transfer/{id}', 'Cms\PoolController@denySectionTransfer')
    ->where('id', '\d+')
    ->name('cms.pool.deny_section_transfer');

Route::any('/pool/approve_section_transfer/{id}', 'Cms\PoolController@approveSectionTransfer')
    ->where('id', '\d+')
    ->name('cms.pool.approve_section_transfer');


Route::any('/pool/answer/{object}/{id}', 'Cms\PoolController@answer')
    ->where('object', '\w+')
    ->where('id', '\d+')
    ->name('cms.pool.answer');

Route::post('/pool/create_answer', 'Cms\PoolController@createAnswer')
    ->name('cms.pool.create_answer');

Route::post('/pool/update_answer', 'Cms\PoolController@updateAnswer')
    ->name('cms.pool.update_answer');

Route::post('/pool/update_complain', 'Cms\PoolController@updateComplain')
    ->name('cms.pool.update_complain');

Route::delete('/pool/delete/{object}/{id}', 'Cms\PoolController@delete')
    ->name('cms.pool.delete')
    ->where('object', '\w+')
    ->where('id', '\d+');