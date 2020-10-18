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
//tasksへのPOSTリクエストに対応するルーティングが実行されている


Route::resource('tasks', 'TasksController');
// CRUD
// メッセージの個別詳細ページ表示

// ユーザ登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup.get');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// 認証
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout.get');



Route::get('/', 'TasksController@index');    // 上書き

Route::group(['middleware' => ['auth']], function () {
    Route::resource('users', 'UsersController', ['only' => ['index', 'show']]);
    Route::resource('tasks', 'TasksController', ['only' => ['edit','update','show','store', 'destroy']]);
});