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

Route::redirect('/', '/cc');

Route::prefix('/cc')->group(function () {

    App::setLocale('en');

    // Main
    Route::get('/', 'HomeController@show')->name('home');
    Route::get('/mods', 'ModController@show')->name('mods');
    Route::get('/tools', 'ToolController@show')->name('tools');

    // Info
    Route::get('/about', 'InfoController@about')->name('about');
    Route::get('/impressum', 'InfoController@impressum')->name('impressum');
    Route::get('/privacy', 'InfoController@privacy')->name('privacy');

    // News
    Route::redirect('/news/{news_id}/1', '/cc/news/{news_id}')->where('news_id', '^[1-9]([0-9]*)$');
    Route::get('/news/{news_id}/{page?}', 'NewsController@show')->name('news')
        ->where('news_id', '^[1-9]([0-9]*)$')
        ->where('page', '^[1-9]([0-9]*)$');

    // Authentication
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

    // Registration
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register');

    // Password Reset
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

});

Route::prefix('/dynimages')->group(function () {

    Route::get('/bg/curcuit_bg', 'SvgController@show')->defaults('svg', 'curcuit');
    Route::get('/elem/download', 'SvgController@show')->defaults('svg', 'download');
    Route::get('/elem/chevron_right', 'SvgController@show')->defaults('svg', 'chevron_right');

    // ext
    Route::get('/elem/github', 'SvgController@show')->defaults('svg', 'ext/github');
    Route::get('/elem/gitlab', 'SvgController@show')->defaults('svg', 'ext/gitlab');
    Route::get('/elem/gitlab_color', 'SvgController@show')->defaults('svg', 'ext/gitlab_color');
    Route::get('/elem/reddit', 'SvgController@show')->defaults('svg', 'ext/reddit');
    Route::get('/elem/twitter', 'SvgController@show')->defaults('svg', 'ext/twitter');
    Route::get('/elem/discord', 'SvgController@show')->defaults('svg', 'ext/discord');

});

Route::redirect('/r/yt-bye', 'https://www.youtube.com/watch?v=LcAFxc_sbYM');