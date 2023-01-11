<?php

use App\Models\Activity;
use App\Models\Article;
use App\Models\BlogArticle;
use App\Models\BlogComment;
use App\Models\BlogSection;
use App\Models\ProfileModule;
use App\Models\ProfileModuleInformation;
use App\Models\ProfileModuleStatus;
use App\Models\ProfileModuleStroke;
use App\Models\UserSession;

Route::group(['prefix' => 'article'], function () {

    Route::get('/show/{title}-{id}.html', 'Api\ProfileModules\BlogArticlesController@show')
        ->name(BlogArticle::class . '.show.on_update')
        ->where('id', '[0-9]+')
        ->where('title', '[A-Za-z0-9\-]+');
});

Route::group(['prefix' => 'api', 'middleware' => ['api']], function () {

    Route::group(['prefix' => 'blog'], function () {

        Route::group(['prefix' => 'article'], function () {

            Route::post('/create', 'Api\ProfileModules\BlogArticlesController@create')
                ->name(BlogArticle::class . '.create')->middleware('user_matches');

            Route::post('/update', 'Api\ProfileModules\BlogArticlesController@update')
                ->name(BlogArticle::class . '.update')->middleware('user_matches');

            Route::post('/delete', 'Api\ProfileModules\BlogArticlesController@delete')
                ->name(BlogArticle::class . '.delete')->middleware('user_matches');

            Route::get('/revisions', 'Api\ProfileModules\BlogArticlesController@revisions')
                ->name(BlogArticle::class . '.revisions')->middleware('user_matches');

            Route::get('/form', 'Api\ProfileModules\BlogArticlesController@form')
                ->name(BlogArticle::class . '.form');

            Route::get('/slug', 'Api\ProfileModules\BlogArticlesController@slug')
                ->name(BlogArticle::class . '.slug')->middleware('user_matches');

            Route::get('/mass_delete', 'Api\ProfileModules\BlogArticlesController@massDelete')
                ->name(BlogArticle::class . '.mass_delete')->middleware('user_matches');

            Route::post('/auto_save', 'Api\ProfileModules\BlogArticlesController@autoSave')
                ->name(BlogArticle::class . '.auto_save');

            Route::get('/show_revision', 'Api\ProfileModules\BlogArticlesController@showRevision')
                ->name(BlogArticle::class . '.show_revision');
        });

        Route::group(['prefix' => 'section'], function () {

            Route::get('/slug', 'Api\ProfileModules\BlogSectionsController@slug')
                ->name(BlogSection::class . '.slug')->middleware('user_matches');

            Route::post('/create', 'Api\ProfileModules\BlogSectionsController@create')
                ->name(BlogSection::class . '.create')->middleware('user_matches');

            Route::post('/delete', 'Api\ProfileModules\BlogSectionsController@delete')
                ->name(BlogSection::class . '.delete')->middleware('user_matches');

            Route::get('/form', 'Api\ProfileModules\BlogSectionsController@form')
                ->name(BlogSection::class . '.form');

            Route::post('/update', 'Api\ProfileModules\BlogSectionsController@update')
                ->name(BlogSection::class . '.update')->middleware('user_matches');
        });

        Route::group(['prefix' => 'comments'], function () {

            Route::post('/add', 'Api\ProfileModules\BlogCommentsController@add')
                ->name(BlogComment::class . '.add');

            Route::post('/delete', 'Api\ProfileModules\BlogCommentsController@delete')
                ->name(BlogComment::class . '.delete');

            Route::post('/update', 'Api\ProfileModules\BlogCommentsController@update')
                ->name(BlogComment::class . '.update')->middleware('user_matches');

            Route::get('/edit', 'Api\ProfileModules\BlogCommentsController@edit')
                ->name(BlogComment::class . '.edit')->middleware('user_matches');

            Route::post('/pin', 'Api\ProfileModules\BlogCommentsController@pin')
                ->name(BlogComment::class . '.pin');

            Route::post('/unpin', 'Api\ProfileModules\BlogCommentsController@unpin')
                ->name(BlogComment::class . '.unpin');

            Route::post('/archive', 'Api\ProfileModules\BlogCommentsController@archive')
                ->name(BlogComment::class . '.archive');

            Route::post('/batch_delete', 'Api\ProfileModules\BlogCommentsController@batchDelete')
                ->name(BlogComment::class . '.batch_delete');

            Route::post('/batch_change_status',
                'Api\ProfileModules\BlogCommentsController@batchChangeStatus')
                ->name(BlogComment::class . '.batch_change_status');

            Route::post('/batch_move', 'Api\ProfileModules\BlogCommentsController@batchMove')
                ->name(BlogComment::class . '.batch_move');

            Route::post('/moderate', 'Api\ProfileModules\BlogCommentsController@moderate')
                ->name(BlogComment::class . '.moderate_blog');
        });
    });

    Route::group(['prefix' => 'profile'], function () {

        Route::group(['prefix' => 'modules'], function () {

            Route::get('/options', 'Api\ProfileModules\OptionsController@index')
                ->name(ProfileModuleStroke::class . '.options');

            Route::get('/home', 'Api\ProfileModules\HomeController@home')
                ->name(ProfileModuleStroke::class . '.home');


            Route::group(['prefix' => 'information'], function () {

                Route::post('/save', 'Api\ProfileModules\InformationController@save')
                    ->name(ProfileModuleInformation::class . '.save')->middleware('user_matches');
            });

            Route::group(['prefix' => 'status'], function () {
                Route::post('/like', 'Api\ProfileModules\StatusController@like')
                    ->name(ProfileModuleStatus::class . '.like');
            });
        });
    });
});

Route::group(['prefix' => 'api'], function () {

    Route::group(['prefix' => 'blog'], function () {

        Route::get('/sections', 'Api\ProfileModules\BlogSectionsController@index')
            ->name(BlogSection::class . '.index');

        Route::get('/articles', 'Api\ProfileModules\BlogArticlesController@index')
            ->name(BlogArticle::class . '.index');

        Route::group(['prefix' => 'section'], function () {

            Route::get('/sort', 'Api\ProfileModules\BlogSectionsController@sort')
                ->name(BlogSection::class . '.sort');

            Route::get('/{section}-{id}', 'Api\ProfileModules\BlogSectionsController@show')
                ->where('id', '[0-9]+')
                ->where('section', '[a-z0-9\/\-]+')
                ->name(BlogSection::class . '.show');
        });

        Route::group(['prefix' => 'article'], function () {

            Route::get('/sort', 'Api\ProfileModules\BlogArticlesController@sort')
                ->name(BlogArticle::class . '.sort');

            Route::get('/{title}-{id}.html', 'Api\ProfileModules\BlogArticlesController@show')
                ->name(BlogArticle::class . '.show')
                ->where('id', '[0-9]+')
                ->where('title', '[A-Za-z0-9\-]+');
        });

        Route::get('/comments', 'Api\ProfileModules\BlogCommentsController@index')
            ->name(BlogComment::class . '.index');
    });

    Route::group(['prefix' => 'profile'], function () {

        Route::group(['prefix' => 'modules'], function () {

            Route::get('/home', 'Api\ProfileModules\HomeController@home')
                ->name(ProfileModule::class . '.home');

            Route::get('/status', 'Api\ProfileModules\StatusController@status')
                ->name(ProfileModuleStatus::class . '.status');

            Route::get('/information', 'Api\ProfileModules\InformationController@information')
                ->name(ProfileModuleStatus::class . '.information');
        });
    });
});


Route::group(['prefix' => 'api'], function () {

    Route::group(['prefix' => 'profile'], function () {

        Route::get('/my-articles', 'Api\ProfileModules\ArticlesController@myArticles')
            ->name(Article::class . '.my_articles');

        Route::get('/activity', 'Api\ProfileController@activity')
            ->name(Activity::class . '.activity')->middleware('api');

        Route::get('/my-articles/sort', 'Api\ProfileModules\ArticlesController@sort')
            ->name(Article::class . '.sort');

        Route::get('/sessions', 'Api\ProfileModules\UserSessionsController@index')
            ->name(UserSession::class . '.index')->middleware(['api', 'user_matches']);
    });
});