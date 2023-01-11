<?php

use App\Models\Domain;

if (php_sapi_name() !== 'cli') {
    $middleware = ['webp', 'web', 'session', 'cookies'];

    foreach (Domain::personal()->get() as $domain) {
        $mainDomain = '{login}.' . $domain->name;

        Route::group(['domain' => $mainDomain, 'middleware' => $middleware],
            function () {

                Route::get('/', 'ProfileController@index')->name('profile.public');

                Route::get('/projects', 'ProfileController@projects');

                Route::get('/articles', 'ProfileController@articles')
                    ->name('public.profile.articles');

                Route::get('/blog', 'ProfileController@blog')
                    ->name('public.profile.blog');

                Route::get('/activity', 'ProfileController@activity')
                    ->name('public.profile.activity');

                Route::get('/cards', 'ProfileController@cards')
                    ->name('public.profile.cards');

                Route::get('/sections', 'ProfileController@sections')
                    ->name('public.profile.sections');

                Route::get('/password/reset', 'Api\AuthController@resetPassword')
                    ->name('public.password.reset');

                Route::get('/edit', 'ProfileController@edit')
                    ->name('public.profile.edit');

                Route::get('/subscriptions', 'ProfileController@subscriptions')
                    ->name('public.profile.subscriptions');

                Route::get('/security', 'ProfileController@security')
                    ->name('public.profile.security');

                Route::get('/profile/security', 'ProfileController@security')
                    ->name('profile.security');

                Route::get('credentials/erase_guest_cookie', 'CredentialsController@eraseGuestCookie')
                    ->name('api.credentials.erease_guest_cookie');

                Route::get('/blog', 'BlogController@articles')
                    ->name('profile.blog.articles');

                Route::get('/sections', 'BlogController@sections')
                    ->name('profile.blog.sections');

                Route::group(['prefix' => 'article'], function () {
                    Route::get('/{title}-{id}.html', 'BlogController@articleShow')
                        ->name('profile.blog.article_show')
                        ->where('id', '[0-9]+')
                        ->where('title', '[A-Za-z0-9\-]+');
                });

                Route::group(['prefix' => 'section'], function () {
                    Route::get('/{title}-{id}', 'BlogController@sectionShow')
                        ->name('profile.blog.section_show')
                        ->where('id', '[0-9]+')
                        ->where('title', '[A-Za-z0-9\-]+');
                });

                Route::group(['prefix' => 'api/profile', 'middleware' => ['api']], function () {
                    Route::post('/save', 'Api\ProfileController@save');
                    Route::post('/save_fields', 'Api\ProfileController@saveFields');
                    Route::post('/save_field', 'Api\ProfileController@saveField');
                    Route::post('/set_field_visibility', 'Api\ProfileController@setFieldVisibility');
                    Route::post('/set_on_homepage', 'Api\ProfileController@setOnHomepage');
                    Route::post('/set_group_visibility', 'Api\ProfileController@setGroupVisibility');
                    Route::post('/save_personal_names', 'Api\ProfileController@savePersonalNames');
                    Route::post('/change_password', 'Api\ProfileController@changePassword');
                    Route::post('/change_email', 'Api\ProfileController@changeEmail');
                    Route::post('/change_phone', 'Api\ProfileController@changePhone');
                    Route::post('/change_language', 'Api\ProfileController@changeLanguage');
                    Route::post('/delete_multi_field/{id}', 'Api\ProfileController@deleteMultiField')
                        ->where('id', '[0-9]+');
                    Route::post('/get_change_code', 'Api\ProfileController@getChangeCode');
                    Route::post('/save_status', 'Api\ProfileController@saveStatus');
                    Route::post('/upload-avatar', 'UploaderController@uploadAvatar');
                    Route::get('/delete_account', 'Api\ProfileController@deleteAccount');
                });

                Route::group(['prefix' => 'api/objects'], function () {
                    Route::get('/show_data', 'Api\Catalog\ObjectsController@showData');
                });

                Route::group(['prefix' => 'api/storage', 'middleware' => 'api'], function () {

                    Route::get('/images', 'Api\StorageController@images')
                        ->name('storage.images');

                    Route::post('/images/sort', 'Api\StorageController@sort')
                        ->name('storage.images.sort');

                    Route::post('/add_base64_files', 'Api\StorageController@addBase64Files')
                        ->name('storage.add_base46_files');

                    Route::post('/add_url', 'Api\StorageController@addUrl')
                        ->name('storage.add_url');
                });

                include('Profile.php');
                include('ProfileModule.php');
                include('Menus.php');
            });


        Route::group(['domain' => $mainDomain . '/', 'middleware' => $middleware],
            function () use ($domain) {

                Route::get('credentials/login/{token}', 'CredentialsController@login')
                    ->where('token', '[a-zA-Z0-9]+')->name('api.credentials.login');

                Route::get('credentials/guest', 'CredentialsController@guest')
                    ->name('personal.credentials.guest');

            });
    }
}