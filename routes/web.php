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

// ログイン・ログアウト
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// 以下管理者用ページ
// トップページ
Route::get('/admin', 'admin\UsersController@top');
// ログイン履歴ページ
Route::get('/admin/login_records', 'admin\UsersController@login_records');
// 管理者操作
Route::resource('/admin/users', 'admin\UsersController');
// お知らせ操作
Route::resource('/admin/notices', 'admin\NoticesController');
// チーム操作
Route::resource('/admin/teams', 'admin\TeamsController');
// アンケート操作
Route::resource('/admin/surveys', 'admin\SurveysController');
// アンケートコメント操作
Route::resource('/admin/surveys/{survey}/comments', 'admin\SurveyCommentsController');
// 非表示のコメント一覧ページ
Route::get('/admin/surveys/{survey}/closed_comments', 'admin\SurveyCommentsController@closed_comments');
