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

Route::get('/', 'ListingsHomeController@index');

Auth::routes([
    'verify' => true
]);

Route::get('/category/{category}', 'ListingCategoryController@show')
    ->name('front.category.show');
Route::get('/listing/{listing}', 'ListingController@show')
    ->name('front.listing.show');


Route::group([
    'middleware' => [
        'verified'
    ]
], function () {
    Route::get('/home', 'HomeController@index')->name('home');

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

    Route::group([
        'middleware' => [
            'admin'
        ],
        'namespace' => 'Administration',
        'prefix' => 'administration'
    ], function () {
        Route::get('/', 'HomeController@getHome')->name('admin.home');

        Route::group([
            'prefix' => 'categories'
        ], function () {

        });

        Route::group([
            'prefix' => 'users'
        ], function () {

        });

        Route::get('category/datatables', 'CategoryController@datatables')
            ->name('category.datatables');
        Route::resource('category', 'CategoryController');

        Route::get('game/datatables', 'GameController@datatables')
            ->name('game.datatables');
        Route::resource('game', 'GameController');

        Route::get('user/datatables', 'UserController@datatables')
            ->name('user.datatables');
        Route::resource('user', 'UserController');


    });
});

