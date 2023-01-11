<?php

Route::group(['prefix' => 'api/storage', 'middleware' => 'api'], function () {
    Route::post('/delete_object', 'Api\StorageController@deleteObject')
        ->name('storage.delete_object')
        ->where('id', '[0-9]+');

    Route::post('/restore', 'Api\StorageController@restore')
        ->name('storage.restore')
        ->where('id', '[0-9]+');

    Route::get('/recycle_bin', 'Api\StorageController@recycleBin')
        ->name('storage.recycle_bin');

    Route::get('/favorite', 'Api\StorageController@favorite')
        ->name('storage.favorite');

    Route::post('/favorite_file', 'Api\StorageController@favoriteFile')
        ->name('storage.favorite_file')
        ->where('id', '[0-9]+');

    Route::post('/unfavorite_file', 'Api\StorageController@unfavoriteFile')
        ->name('storage.unfavorite_file')
        ->where('id', '[0-9]+');

    Route::get('/images', 'Api\StorageController@images')
        ->name('storage.images');

    Route::get('/totals', 'Api\StorageController@totals')
        ->name('storage.totals');

    Route::post('/images/sort', 'Api\StorageController@sort')
        ->name('storage.images.sort');

    Route::get('/files', 'Api\StorageController@files')
        ->name('storage.files');

    Route::get('/objects', 'Api\StorageController@objects')
        ->name('storage.objects');

    Route::post('/tag/{name}', 'Api\StorageController@tag')
        ->name('storage.tag');

    Route::post('/delete_tag', 'Api\StorageController@deleteTag')
        ->name('storage.delete_tag');

    Route::post('/update_tag', 'Api\StorageController@updateTag')
        ->name('storage.update_user_tag');

    Route::post('/add_tag_to_object', 'Api\StorageController@addTagToObject')
        ->name('storage.add_tag_to_object');

    Route::post('/add_tag', 'Api\StorageController@addTag')
        ->name('storage.add_tag');

    Route::post('/filter_tag', 'Api\StorageController@filterTag')
        ->name('storage.filter_tag');

    Route::post('/add_files', 'Api\StorageController@addFiles')
        ->name('storage.add_files');

    Route::post('/add_base64_files', 'Api\StorageController@addBase64Files')
        ->name('storage.add_base46_files');

    Route::post('/add_url', 'Api\StorageController@addUrl')
        ->name('storage.add_url');

    Route::get('/tags', 'Api\StorageController@tags')
        ->name('storage.tags');

    Route::get('/tag_tree', 'Api\StorageController@tagTree')
        ->name('storage.tag_tree');

    Route::get('/search_tag', 'Api\StorageController@searchTag')
        ->name('storage.search_tag');

    Route::get('/search', 'Api\StorageController@search')
        ->name('storage.search');

    Route::get('/no_file_tags', 'Api\StorageController@noFileTags')
        ->name('storage.no_file_tags');

    Route::post('/add_multi_tag', 'Api\StorageController@addMultiTag')
        ->name('storage.add_multi_tag');

    Route::post('/multi_recycle', 'Api\StorageController@multiRecycle')
        ->name('storage.multi_recycle');

    Route::post('/batch_delete_tags', 'Api\StorageController@batchDeleteTags')
        ->name('storage.batch_delete_tags');

    Route::post('/multi_download', 'Api\StorageController@multiDownload')
        ->name('storage.multi_download');

    Route::post('/add_contact', 'Api\StorageController@addContact')
        ->name('storage.add_contact');

    Route::post('/add_contact', 'Api\StorageController@addContact')
        ->name('storage.add_contact');

    Route::post('/combine_tags', 'Api\StorageController@combineTags')
        ->name('storage.combine_tags');

    Route::post('/add_image', 'Api\StorageController@addImage')
        ->name('storage.add_image');

    Route::post('/validate_url_image', 'Api\StorageController@validateUrlImage')
        ->name('storage.validate_url_image');

    Route::post('/add_images', 'Api\StorageController@addImages')
        ->name('storage.add_images');

    Route::get('/download_zip/{zipname}', 'Api\StorageController@downloadZip')
        ->name('storage.download_zip');

    Route::post('/get_image_from_url', 'Api\StorageController@getImageFromUrl')
        ->name('storage.get_image_from_url');

    Route::post('/add_chunked_files', 'Api\StorageController@addChunkedFiles')
        ->name('storage.add_chunked_files')->middleware(config('app.default_middleware'));
});

Route::group(['prefix' => 'api/storage'], function () {
    Route::get('/download/{id}', 'Api\StorageController@download')
        ->name('storage.download')
        ->where('id', '[0-9]+');
});