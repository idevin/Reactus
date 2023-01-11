<?php

$jsonResponse = new class {
    use App\Traits\Response;
};

Route::group(['middleware' => config('app.default_middleware') + ['throttle:100,0.5']],
    function () use ($jsonResponse) {

        include('Routes/Cms/Cms.php');
        include('Routes/Social.php');

        Route::get('/500', 'HomeController@error500');

        Route::get('/unsupported-browser', 'HomeController@unsupportedBrowser');

        Route::get('/rss', 'Api\SitesController@rss');

        Route::get('/yandex-market.xml', 'Api\SitesController@yandexMarket');

        Route::get('/sales/{id}', 'HomeController@sales')->where('id', '\d+');

        Route::get('/admin', 'HomeController@admin');

        Route::get('/sitemap.xml', 'Api\SitesController@sitemap')->name('sitemap.xml');

        Route::group(['prefix' => '/api', 'middleware' => 'api'], function () {

            Route::group(['prefix' => '/export'], function () {
                Route::post('/site', 'Api\ExportController@site')
                    ->name('api.export.site');
            });
        });

        Route::group(['prefix' => '/api/deletable_objects'], function () {
            Route::get('/', 'Api\DeletableObjectsController@index')
                ->name('api.deletable_objects.index');

            Route::post('/destroy', 'Api\DeletableObjectsController@destroy')
                ->name('api.deletable_objects.destroy');
        });

        include('Routes/Sections.php');
        include('Routes/Articles.php');
        include('Routes/Pages.php');
        include('Routes/Credentials.php');
        include('Routes/UserCart.php');
        include('Routes/Time.php');

        Route::group(['middleware' => ['cookies', 'check_site', 'domain']], function () {

            include('Routes/Personal.php');
            include('Routes/Domains.php');
            include('Routes/Pool.php');
            include('Routes/Storage.php');
            include('Routes/Sites.php');
            include('Routes/Menus.php');
            include('Routes/Comments.php');
            include('Routes/Profile.php');
            include('Routes/Activity.php');
            include('Routes/Subscribe.php');
            include('Routes/TrashBin.php');
            include('Routes/Templates.php');
            include('Routes/Colors.php');
            include('Routes/Language.php');
            include('Routes/ObjectRelations.php');
            include('Routes/Cards.php');
            include('Routes/Objects.php');
            include('Routes/Roboto.php');
            include('Routes/Billing.php');
            include('Routes/Announcement.php');
            include('Routes/Contacts.php');
            include('Routes/Feedback.php');

            Route::get('/contacts', 'ContactsController@index');
            Route::get('/about', 'AboutController@index');
            Route::group(['middleware' => ['webp', 'auth_server']], function () {

                Route::get('/profile', 'ProfileController@show');

                Route::get('/profile/articles', 'ProfileController@articles');

                Route::get('/profile/sections', 'ProfileController@sections');

                Route::get('/profile/edit', 'ProfileController@edit');

                Route::get('/profile/subscriptions', 'ProfileController@subscriptions');

                Route::get('/profile/security', 'ProfileController@security');

                Route::get('/', 'HomeController@index')->name('home');
            });

            Route::group(['middleware' => []], function () {

                Route::group(['prefix' => 'api'], function () {
                    Route::post('/register', 'Api\RegisterController@register');
                    Route::post('/register/v2', 'Api\RegisterController@registerV2');
                    Route::post('/login', 'Api\AuthController@login');
                    Route::get('/logged', 'Api\AuthController@logged');
                    Route::post('/profile/save', 'Api\ProfileController@save');
                });


                Route::get('/article/revision/{id}', 'ArticleController@revision')
                    ->name('article.revision')
                    ->where('id', '\d+');

                Route::get('/l/{id}', 'HomeController@login')
                    ->name('home.login');

                Route::get('/c', 'HomeController@cookie')
                    ->name('home.c');

                include('Routes/Rating.php');
                /**
                 * ApiArticles
                 */
                include('Routes/ArticleGroups.php');
                include('Routes/ModulesV2.php');
                include('Routes/Time.php');
            });

            Route::group(['middleware' => ['cors', 'auth_server']], function () {

                Route::get('/confirm_password_change/{hash}', 'ProfileController@confirmPasswordChange')
                    ->name('confirm_password_change')
                    ->where('hash', '[A-Za-z0-9=]+');

                Route::get('/confirm_email_change/{hash}', 'ProfileController@confirmEmailChange')
                    ->name('confirm_email_change')
                    ->where('hash', '[A-Za-z0-9=]+');

                Route::get('/confirm_phone_change/{hash}', 'ProfileController@confirmPhoneChange')
                    ->name('confirm_phone_change')
                    ->where('hash', '[A-Za-z0-9=]+');

                // Sites
                Route::get('/sites', 'SiteController@index')
                    ->name('site.index');

                Route::group(['prefix' => 'tags'], function () {
                    Route::get('/delete/{tag_id}', 'StorageTagController@deleteTag')
                        ->name('tag.delete')
                        ->where('tag_id', '[0-9]+');

                    Route::get('/edit/{tag_id}', 'StorageTagController@editTag')
                        ->name('tag.edit')
                        ->where('tag_id', '[0-9]+');
                });

                Route::post('/api/complains/article/send', 'Api\ComplainsController@article')
                    ->name('complains.article.send');

                Route::post('/api/complains/comment/send', 'Api\ComplainsController@comment')
                    ->name('complains.comment.send');

                Route::get('/moderation_answer/{id}/confirm', 'ModerationAnswerController@confirm')
                    ->where('id', '\d+')
                    ->name('moderation_answer.confirm');

            });

            Route::get('r', 'RedirectController@index')
                ->name('redirect.index');

            Route::get('contacts', 'ContactsController@index')
                ->name('contacts.index');

            Route::group(['prefix' => 'api'], function () {

                Route::group(['middleware' => ['api']], function () {
                    Route::post('/users/permissions', 'Api\UsersController@permissions')
                        ->name('api.user.permissions');

                    Route::get('/users/search', 'Api\UsersController@search')
                        ->name('api.user.search');

                    Route::post('/tags/search', 'Api\TagsController@search')
                        ->name('api.tags.search')
                        ->where('term', '[A-Za-z0-9]+');
                });

                Route::get('/search/city', 'Api\SearchController@city')
                    ->name('search.city')
                    ->where('term', '[A-Za-z0-9]+');

                Route::get('/search/country', 'Api\SearchController@country')
                    ->name('search.country')
                    ->where('term', '[A-Za-z0-9]+');

                include('Routes/Auth.php');
            });

            include('Routes/Settings.php');
        });
    });