<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes([
    'verify' => true
]);

Route::group([
    'middleware' => [
        'site_online'
    ]
], function () {

    Route::get('/', 'ListingHomeController@index')
        ->name('home');

    Route::get('/category/{category}', 'ListingCategoryController@show')
        ->name('front.category.show');

    Route::get('/listing/{listing}', 'ListingController@show')
        ->name('front.listing.show');

    Route::get('contact', 'ContactController@index')
        ->name('front.contact');

    Route::post('contact', 'ContactController@store')
        ->name('front.contact.store');

    Route::get('out/{listing}', 'ListingController@out')
        ->name('listing.out');

    Route::get('in/{listing}', 'ListingController@in')
        ->name('listing.in');

    Route::post('in/{listing}', 'ListingController@vote')
        ->name('listing.vote');


    Route::group([
        'middleware' => [
            'verified'
        ]
    ], function () {

        Route::resource('game', 'GameController')
            ->names([
                'index' => 'front.game.index',
                'create' => 'front.game.create',
                'store' => 'front.game.store',
                'show' => 'front.game.show',
                'edit' => 'front.game.edit',
                'update' => 'front.game.update',
                'destroy' => 'front.game.destroy',
            ]);

        Route::get('/account', 'AccountController@index')
            ->name('account.index');

        Route::post('/account/email', 'AccountController@updateEmail')
            ->name('account.email.post');

        Route::post('/account/password', 'AccountController@updatePassword')
            ->name('account.password.post');

        Route::get('/account/email', 'AccountController@getEmail')
            ->name('account.email');

        Route::get('/account/password', 'AccountController@getPassword')
            ->name('account.password');

        Route::get('/image/upload', 'ImageUploadController@fileCreate');
        Route::post('/image/upload/store', 'ImageUploadController@fileStore');
        Route::post('/image/delete', 'ImageUploadController@fileDestroy');

        Route::group([
            'middleware' => [
                'admin'
            ],
            'namespace' => 'Administration',
            'prefix' => 'administration'
        ], function () {
            Route::get('/', 'HomeController@getHome')->name('admin.home');

            Route::get('settings', 'SettingsController@showSettings')
                ->name('settings.edit');

            Route::put('settings', 'SettingsController@updateSettings')
                ->name('settings.update');

            Route::put('settings/seo', 'SettingsController@updateSEO')
                ->name('settings.seo.update');

            Route::get('category/datatables', 'CategoryController@datatables')
                ->name('category.datatables');
            Route::resource('category', 'CategoryController');

            Route::get('game/datatables', 'GameController@datatables')
                ->name('game.datatables');
            Route::resource('game', 'GameController');

            Route::post('game/approve/{game}', 'GameController@approveGame')
                ->name('game.approve');

            Route::post('game/reject/{game}', 'GameController@rejectGame')
                ->name('game.reject');

            Route::get('user/datatables', 'UserController@datatables')
                ->name('user.datatables');
            Route::resource('user', 'UserController');

            Route::get('contact/datatables', 'ContactController@datatables')
                ->name('contact.datatables');

            Route::get('contact', 'ContactController@index')
                ->name('contact.index');

            Route::get('contact/{contact}', 'ContactController@show')
                ->name('contact.show');

            Route::put('contact/{contact}', 'ContactController@update')
                ->name('contact.update');
        });
    });
});
