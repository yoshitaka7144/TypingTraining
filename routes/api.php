<?php

use Illuminate\Http\Request;

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

// ログインユーザー
Route::get('/user', fn() => Auth::user())->name('user');

// ログイン
Route::post('/login', 'Auth\LoginController@login')->name('login');
// ログアウト
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
// ユーザー登録
Route::post('/register', 'Auth\RegisterController@register')->name('register');

// ログイン時のみ
Route::group(["middleware" => "auth"], function () {
  // 一覧取得
  Route::get('/question', 'QuestionController@index')->name('question');

  // 問題登録
  Route::post('/question', 'QuestionController@store')->name('question.create');
});
