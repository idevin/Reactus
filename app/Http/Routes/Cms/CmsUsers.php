<?php
Route::group(['prefix' => 'users', 'middleware' => ['web', 'session']], function () {

    Route::get('/', 'Cms\UsersController@index')
        ->name('cms.users.index');

    Route::get('/{user_id}/edit', 'Cms\UsersController@edit')
        ->name('cms.users.edit')
        ->where('user_id', '\d+');

    Route::post('/{user_id}/update', 'Cms\UsersController@update')
        ->name('cms.users.update')
        ->where('user_id', '\d+');

    Route::delete('/{user_id}/destroy', 'Cms\UsersController@delete')
        ->name('cms.users.destroy')
        ->where('user_id', '\d+');

    Route::any('/mass_change', 'Cms\UsersController@massChange')
        ->name('cms.users.mass_change')
        ->where('user_id', '\d+');

});
