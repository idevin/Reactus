<?php

Route::group(['prefix' => 'api', 'middleware' => ['api']], function () {

    Route::group(['prefix' => 'currency'], function () {
        Route::post('/convert', 'Billing\CurrencyController@convert')->name('api.currency.convert');
    });

    Route::group(['prefix' => 'balance'], function () {
        Route::post('/add', 'Billing\BalanceController@add');
        Route::get('/update', 'Billing\BalanceController@update')->name('billing.update.balance');
    });

    Route::group(['prefix' => 'tariffs'], function () {
        Route::post('/pay', 'Billing\TariffsController@pay');
        Route::get('/info', 'Billing\TariffsController@info');
        Route::get('/', 'Billing\TariffsController@index');
    });

    Route::group(['prefix' => 'services'], function () {
        Route::post('/pay', 'Billing\ServicesController@pay');
        Route::get('/info', 'Billing\ServicesController@info');

    });

    Route::group(['prefix' => 'billing'], function () {
        Route::get('/history', 'Billing\BillingController@history');
    });

    Route::group(['prefix' => 'subscriptions'], function () {
        Route::post('/delete', 'Billing\SubscriptionsController@delete');
    });

    Route::group(['prefix' => 'subscription_services'], function () {
        Route::post('/delete', 'Billing\SubscriptionServicesController@delete');
    });

    Route::group(['prefix' => 'profile'], function () {
        Route::get('/services', 'Billing\MyServicesController@index');
        Route::get('/tariffs', 'Billing\MyTariffsController@index');
        Route::get('/sites', 'Billing\MySitesController@index');
    });
});

Route::group(['prefix' => 'billing'], function () {
    Route::get('/balance', 'BillingController@balance');
    Route::get('/history', 'BillingController@history');
    Route::get('/tariffs', 'BillingController@tariffs');
    Route::get('/services', 'BillingController@services');
    Route::get('/dashboard', 'BillingController@dashboard');
});

Route::group(['prefix' => 'balance'], function () {
    Route::get('/update', 'BillingController@updateBalance')->name('balance.update');
});

Route::group(['prefix' => 'api'], function () {

    Route::group(['prefix' => 'currency'], function () {
        Route::post('/convert_to_points', 'Billing\CurrencyController@convertToPoints')->name('api.currency.convert_to_points');
        Route::get('/form', 'Billing\CurrencyController@form')->name('api.currency.form');
        Route::get('/get_discounts', 'Billing\CurrencyController@getDiscounts')->name('api.currency.get_discounts');
    });

    Route::group(['prefix' => 'tariffs'], function () {
        Route::get('/', 'Billing\TariffsController@index');
    });

    Route::get('/discount', 'Billing\BillingController@discount');
    Route::post('/calc-tariff-discount', 'Billing\BillingController@calcTariffsDiscount');
    Route::get('/services', 'Billing\ServicesController@index');
});

Route::group(['middleware' => ['auth_server']], function () {
    Route::get('/projects', 'BillingController@projects');
});