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

// 以下ゲスト用画面
// トップ画面
Route::get('/', 'guest\TopPageController@top');
// お問い合わせ
Route::get('/contact', 'guest\TopPageController@contact');
Route::post('/send', 'guest\TopPageController@send');
// このサイトについて
Route::get('/about', 'guest\TopPageController@about');
// サイト紹介ページ
Route::get('/welcome', 'guest\TopPageController@welcome');

// 以下投票操作
// 投票操作
Route::resource('/matches', 'guest\MatchesController');


// 以下管理者用画面
// トップ画面
Route::get('/admin', 'admin\UsersController@top');
// ログイン履歴画面
Route::get('/admin/login_records', 'admin\UsersController@login_records');
// 管理者操作
Route::resource('/admin/users', 'admin\UsersController');
// お知らせ操作
Route::resource('/admin/notices', 'admin\NoticesController');
// チーム操作
Route::resource('/admin/teams', 'admin\TeamsController');

// 以下アンケート操作
// アンケート操作
Route::resource('/admin/surveys', 'admin\SurveysController');
// アンケートコメント操作
Route::resource('/admin/surveys/{survey}/comments', 'admin\SurveyCommentsController');
// 非表示のコメント一覧画面
Route::get('/admin/surveys/{survey}/closed_comments', 'admin\SurveyCommentsController@closed_comments');

// 以下投票操作
// 投票記入内容確認画面
Route::post('/admin/matches/confirm', 'admin\MatchesController@confirm');
// 投票記入修正画面（これを下のresourceより下にすると不具合起きるので注意）
Route::get('/admin/matches/revise', 'admin\MatchesController@revise');
// 投票編集記入確認画面
Route::post('/admin/matches/edit_confirm', 'admin\MatchesController@edit_confirm');
// 投票編集記入修正画面（これを下のresourceより下にすると不具合起きるので注意）
Route::get('/admin/matches/edit_revise', 'admin\MatchesController@edit_revise');
// 投票操作
Route::resource('/admin/matches', 'admin\MatchesController');
// 投票コメント操作
Route::resource('/admin/matches/{match}/comments', 'admin\MatchCommentsController');
// 非表示のコメント一覧画面
Route::get('/admin/matches/{match}/closed_comments', 'admin\MatchCommentsController@closed_comments');

