<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

/**
 * 認証系
 */
// 会員登録
Route::post('/register', 'AuthController@register')->name('register');
// ログイン
Route::post('/login', 'AuthController@login')->name('login');
// ログアウト
Route::post('/logout', 'AuthController@logout')->name('logout');
// ログインユーザー
Route::get('/login_user', 'AuthController@login_user')->name('login_user');
// トークンリフレッシュ
Route::get('/reflesh_token', 'AuthController@reflesh_token')->name('reflesh_token');

/**
 * 記事
 */
Route::resource('articles', 'ArticleController')->except(['create', 'show', 'edit']);

/**
 * ユーザー
 */
Route::resource('users', 'UserController')->only(['show', 'update', 'destroy']);
