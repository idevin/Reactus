<?php

use App\Models\Modules\ModuleArticle;
use App\Models\Modules\ModuleCatalog;
use App\Models\Modules\ModuleCompetitiveAdvantages;
use App\Models\Modules\ModuleFeedback;
use App\Models\Modules\ModuleSection;
use App\Models\Modules\ModuleSlider;

Route::group(['prefix' => 'api/modules/v2'], function () {
    Route::group(['prefix' => '/article'], function () {

        Route::get('/sort', 'Api\Modules\v2\ArticleController@sort')
            ->name(ModuleArticle::class . '.sort_module_article');
    });

    Route::group(['prefix' => '/feedback'], function () {
        Route::post('/send', 'Api\Modules\v2\FeedbackController@send')
            ->name(ModuleFeedback::class . '.send');
    });

    Route::group(['prefix' => '/section'], function () {
        Route::get('/sort', 'Api\Modules\v2\SectionController@sort')
            ->name(ModuleSection::class . '.sort_module_section');
    });

    Route::group(['prefix' => '/feedback'], function () {
        Route::post('/send', 'Api\Modules\v2\FeedbackController@send')
            ->name(ModuleFeedback::class . 'send_v2');
    });
});

Route::group(['prefix' => 'api/modules/v2', 'middleware' => ['api']], function () {

    Route::group(['prefix' => '/slider'], function () {

        Route::post('/validate', 'Api\Modules\v2\SliderController@validateSlide')
            ->name(ModuleSlider::class . 'validate_v2');
    });

    Route::group(['prefix' => '/slide'], function () {

        Route::post('/delete', 'Api\Modules\v2\SlideController@delete')
            ->name(ModuleSlider::class . 'delete_v2');

        Route::post('/add_or_update', 'Api\Modules\v2\SlideController@addOrUpdate')
            ->name(ModuleSlider::class . 'add_or_update_v2');
    });

    Route::group(['prefix' => '/menu_advanced'], function () {
        Route::post('/create', 'Api\Modules\v2\MenuAdvancedController@create');
        Route::post('/sort', 'Api\Modules\v2\MenuAdvancedController@sort');
        Route::post('/delete', 'Api\Modules\v2\MenuAdvancedController@delete');
        Route::post('/update', 'Api\Modules\v2\MenuAdvancedController@update');
        Route::get('/form', 'Api\Modules\v2\MenuAdvancedController@form');
        Route::get('/search', 'Api\Modules\v2\MenuAdvancedController@search');
    });

    Route::group(['prefix' => '/competitive-advantages/items'], function () {

        Route::post('/delete', 'Api\Modules\v2\CompetitiveAdvantagesController@delete')
            ->name(ModuleCompetitiveAdvantages::class . 'delete_v2');

        Route::post('/copy', 'Api\Modules\v2\CompetitiveAdvantagesController@copy')
            ->name(ModuleCompetitiveAdvantages::class . 'copy_v2');

        Route::post('/add_or_update', 'Api\Modules\v2\CompetitiveAdvantagesController@addOrUpdate')
            ->name(ModuleCompetitiveAdvantages::class . 'add_or_update_v2');
    });

    Route::group(['prefix' => '/catalog'], function () {

        Route::post('/create', 'Api\Modules\v2\CatalogController@create')
            ->name(ModuleCatalog::class . '.create');

        Route::get('/edit', 'Api\Modules\v2\CatalogController@edit')
            ->name(ModuleCatalog::class . '.edit');

        Route::post('/delete', 'Api\Modules\v2\CatalogController@delete')
            ->name(ModuleCatalog::class . '.delete');

        Route::post('/update', 'Api\Modules\v2\CatalogController@update')
            ->name(ModuleCatalog::class . '.update');

        Route::get('/get_filter_data', 'Api\Modules\v2\CatalogController@getFilterData')
            ->name(ModuleCatalog::class . '.get_filter_data');

        Route::get('/form', 'Api\Modules\v2\CatalogController@form')
            ->name(ModuleCatalog::class . '.form');
    });
});