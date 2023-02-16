<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BE\LoginControllerAPI;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['web']], function () {
    /* Login */
    Route::POST('login', 'App\Http\Controllers\BE\LoginControllerAPI@login');
    Route::POST('register', 'App\Http\Controllers\BE\UserControllerAPI@save');
    Route::GET('logout', 'App\Http\Controllers\BE\LoginControllerAPI@logout');
});

Route::group(['middleware' => ['web', 'auth']], function () {
    /* Admin LSP Management */
    Route::POST('admin/dt', 'App\Http\Controllers\BE\AdminControllerAPI@dt');
    Route::GET('admin/{id}', 'App\Http\Controllers\BE\AdminControllerAPI@getById');
    Route::POST('admin', 'App\Http\Controllers\BE\AdminControllerAPI@save');
    Route::DELETE('admin/{id}', 'App\Http\Controllers\BE\AdminControllerAPI@delete');

    /* User LSP Management */
    Route::POST('user', 'App\Http\Controllers\BE\UserControllerAPI@edit');

    /* Item Management */
    Route::POST('item/dt', 'App\Http\Controllers\BE\ItemControllerAPI@dt')->name('item.dt');
    Route::GET('item/{id}', 'App\Http\Controllers\BE\ItemControllerAPI@getById');
    Route::POST('item', 'App\Http\Controllers\BE\ItemControllerAPI@save');
    Route::DELETE('item/{id}', 'App\Http\Controllers\BE\ItemControllerAPI@delete');

    /* Buy Item Management */
    Route::POST('buy/{id}/{qty}', 'App\Http\Controllers\BE\BuyItemControllerAPI@save');

    /* Category Management */
    Route::POST('category/dt', 'App\Http\Controllers\BE\CategoryControllerAPI@dt');
    Route::GET('category/{id}', 'App\Http\Controllers\BE\CategoryControllerAPI@getById');
    Route::POST('category', 'App\Http\Controllers\BE\CategoryControllerAPI@save');
    Route::DELETE('category/{id}', 'App\Http\Controllers\BE\CategoryControllerAPI@delete');

    /* WIZIWIG */
    Route::post('ckeditor/upload', 'App\Http\Controllers\BE\CKEditorController@upload')->name('ckeditor.image-upload');

    Route::prefix('auth')->group(function () {
        Route::get('/change-role/{id_role}', 'App\Http\Controllers\BE\UserControllerAPI@changeRole')->name('change-role');
    });
});
