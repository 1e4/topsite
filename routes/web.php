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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes([
    'verify'    =>  true
]);


Route::group([
    'middleware'    =>  [
        'verified'
    ]
], function() {
    Route::get('/home', 'HomeController@index')->name('home');

    Route::group([
        'middleware'    =>  [
            'isAdmin'
        ],
        'namespace' =>  'Administration',
        'prefix'    =>  'administration'
    ], function() {
        Route::get('/', 'HomeController@getHome')->name('admin.home');

        Route::group([
            'prefix'    =>  'categories'
        ], function() {

        });

        Route::group([
            'prefix'    =>  'users'
        ], function() {

        });

        Route::resource('category', 'CategoryController');

        Route::resource('game', 'GameController');

        Route::resource('user', 'UserController');


    });
});

