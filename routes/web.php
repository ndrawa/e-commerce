<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => ['web']], function () {
    // Landing Page
    Route::GET('/', 'App\Http\Controllers\FE\LandingPageController@index')->name('home');
    Route::get('/profile', 'App\Http\Controllers\FE\LandingPageController@profile')->name('home.profile');
    Route::get('/item', 'App\Http\Controllers\FE\ItemController@home')->name('home.item');
    Route::get('/item/{id}', 'App\Http\Controllers\FE\ItemController@detail')->name('home.item.detail');

    // Login
    Route::GET('/login', 'App\Http\Controllers\FE\LoginController@login')->name('login');
    Route::GET('/register', 'App\Http\Controllers\FE\LoginController@register')->name('register');

    // Logged In
    Route::middleware(['auth'])->group(function () {
        Route::get('/session', function () {
            return Auth::user();
        });

        Route::prefix('dashboard')->middleware(['not_allowed_role:GUEST'])->group(function () {
            Route::get('/', 'App\Http\Controllers\FE\DashboardController@index')->name('dashboard.index');
        });

        Route::prefix('master')->group(function () {
            Route::group(['middleware' => ['allowed_role:ADMIN'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
                Route::get('/', 'App\Http\Controllers\FE\AdminController@index')->name('index');
            });

            Route::group(['middleware' => ['not_allowed_role:GUEST'], 'prefix' => 'user', 'as' => 'user.'], function () {
                Route::get('/', 'App\Http\Controllers\FE\UserController@index')->name('index');
            });

            Route::group(['middleware' => ['allowed_role:ADMIN'], 'prefix' => 'item', 'as' => 'item.'], function () {
                Route::get('/', 'App\Http\Controllers\FE\ItemController@index')->name('index');
                Route::get('/add', 'App\Http\Controllers\FE\ItemController@add')->name('add');
                Route::get('/{id}', 'App\Http\Controllers\FE\ItemController@edit')->name('edit');
            });
        });
        Route::prefix('buy')->group(function () {
            Route::group(['middleware' => ['allowed_role:USER'], 'prefix' => 'items', 'as' => 'items.'], function () {
                Route::get('/', 'App\Http\Controllers\FE\BuyItemController@index')->name('index');
                Route::get('/history', 'App\Http\Controllers\FE\BuyItemController@history')->name('history');
                Route::get('/history/detail/{id}', 'App\Http\Controllers\FE\BuyItemController@detail')->name('history.detail');
            });
        });
    });
});

