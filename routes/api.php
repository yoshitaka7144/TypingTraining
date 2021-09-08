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

// ログインユーザー取得
Route::get('/user', fn() => Auth::user())->name('user');

// ログイン
Route::post('/login', 'Auth\LoginController@login')->name('login');

// ログアウト
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

// ユーザー登録
Route::post('/register', 'Auth\RegisterController@register')->name('register');

// カテゴリー取得
Route::get('/category', 'CategoryController@index')->name('category');

// 指定カテゴリーの問題取得
Route::get('/question/category/{categoryId}', 'QuestionController@category')->name('question.category');

Route::post('/roman', 'RomanController@index')->name('roman');

// ログイン時のみ
Route::group(["middleware" => "auth"], function () {
  // 問題一覧取得
  Route::get('/question', 'QuestionController@index')->name('question');

  // 問題登録
  Route::post('/question', 'QuestionController@store')->name('question.create');

  // 問題取得
  Route::get('/question/{question}', 'QuestionController@show')->name('question.show');

  // 問題更新
  Route::put('/question/{question}', 'QuestionController@update')->name('question.update');

  // 問題削除
  Route::delete('/question/{question}', 'QuestionController@destroy')->name('question.destroy');

  // ユーザー情報更新
  Route::put('/user/{user}', 'UserController@update')->name('user.update');

  // 履歴一覧取得
  Route::get('/history', 'HistoryController@index')->name('history');

  // 履歴登録
  Route::post('/history', 'HistoryController@store')->name('history.create');
});
