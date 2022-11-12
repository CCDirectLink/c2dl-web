<?php

use Illuminate\Support\Facades\App;
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

Route::redirect('/', '/cc');

Route::prefix('/cc')->group(function () {

    App::setLocale('en');

    // Main
    Route::get('/', 'HomeController@show')->name('home');

    // Mods
    Route::redirect('/mods/1', '/cc/mods');
    Route::get('/mods/{page?}', 'ModController@show')->name('mods')
        ->where('page', '^[1-9]([0-9]*)$');

    // Tools
    Route::redirect('/tools/1', '/cc/tools');
    Route::get('/tools/{page?}', 'ToolController@show')->name('tools')
        ->where('page', '^[1-9]([0-9]*)$');

    // Info
    Route::get('/about', 'InfoController@about')->name('about');
    // Route::get('/impressum', 'InfoController@impressum')->name('impressum');
    // Route::get('/privacy', 'InfoController@privacy')->name('privacy');

    // News
    Route::redirect('/news/{news_id}/1', '/cc/news/{news_id}')
        ->where('news_id', '^[1-9]([0-9]*)$');

    Route::get('/news/{news_id}/{page?}', 'NewsController@show')->name('news')
        ->where('news_id', '^[1-9]([0-9]*)$')
        ->where('page', '^[1-9]([0-9]*)$');

    // RSS Feed
    Route::get('/news/feed', 'NewsController@rssFeed')->name('news.feed');

    // Authentication
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

    // Registration
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register');

    // Password Reset
    // Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
    // Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    // Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
    // Route::post('password/reset', 'Auth\ResetPasswordController@reset');
});

Route::redirect('/wiki', 'https://wiki.c2dl.info')->name('wiki');

Route::redirect('/r/yt-bye', 'https://www.youtube.com/watch?v=LcAFxc_sbYM');
Route::get('/r/md', 'SocialController@redirectDiscordJoin');
