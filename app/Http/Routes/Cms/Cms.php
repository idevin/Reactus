<?php

Route::group(['prefix' => 'cms', 'middleware' => ['web', 'session']], function () {

    Route::group(['middleware' => ['cms']], function () {
        Route::get('/', 'Cms\CmsController@index')
            ->name('cms.index');

        Route::get('/logout', 'Cms\LoginController@logout')
            ->name('cms.logout');

        include('CmsUsers.php');
        include('CmsTariffs.php');
        include('CmsService.php');
        include('CmsDiscount.php');
        include('CmsBillingConstructor.php');
        include('CmsRoles.php');
        include('CmsDomains.php');
        include('CmsPermissions.php');
        include('CmsForms.php');
        include('CmsFormGroups.php');
        include('CmsFeedback.php');
        include('CmsDomains.php');
        include('CmsSiteSections.php');
        include('CmsSites.php');
        include('CmsSettings.php');
        include('CmsSiteUsers.php');
        include('CmsSiteSections.php');
        include('CmsSectionsSite.php');
        include('CmsTemplates.php');
        include('CmsSections.php');
        include('CmsSectionUsers.php');
        include('CmsArticles.php');
        include('CmsComments.php');
        include('CmsPool.php');
        include('CmsComplainOptions.php');
        include('CmsComplains.php');
        include('CmsThematic.php');
        include('CmsLanguage.php');
        include('CmsObjects.php');
        include('CmsObjectFields.php');
        include('CmsObjectFieldsRelations.php');
        include('CmsObjectFieldGroups.php');
        include('CmsSubscriptions.php');
        include('CmsActivities.php');
        include('CmsCurrencies.php');
        include('CmsServiceOptions.php');
        include('CmsTemplatePrototypes.php');
    });

    Route::get('/login', 'Cms\LoginController@index')
        ->name('cms.login');

    Route::post('/login/auth', 'Cms\LoginController@postLogin')
        ->name('login.auth');
});
