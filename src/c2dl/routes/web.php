<?php

use App\Http\Controllers\UserConfigController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ModController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\ToolController;
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

    $_numeric = '^[1-9]([0-9]*)$';
    $_alpha = '^[a-z]*$';

    App::setLocale('en');

    // Main
    Route::get('/', [HomeController::class, 'show'])->name('home');

    // Mods
    Route::redirect('/mods/1', '/cc/mods');
    Route::get('/mods/{page?}', [ModController::class, 'show'])->name('mods')
        ->where('page', $_numeric);

    // Tools
    Route::redirect('/tools/1', '/cc/tools');
    Route::get('/tools/{page?}',  [ToolController::class, 'show'])->name('tools')
        ->where('page', $_numeric);

    // News
    Route::redirect('/news/{news_id}/1', '/cc/news/{news_id}')
        ->where('news_id', $_numeric);

    Route::get('/news/{news_id}/{page?}', [NewsController::class, 'show'])->name('news')
        ->where('news_id', $_numeric)
        ->where('page', $_numeric);

    Route::get('/user/config/colorset', [UserConfigController::class, 'colorset'])
        ->name('colorset');

    // RSS Feed
    Route::get('/news/feed', [NewsController::class, 'rssFeed'])->name('news.feed');

});

Route::redirect('/wiki', 'https://wiki.c2dl.info')->name('wiki');

Route::redirect('/r/yt-bye', 'https://www.youtube.com/watch?v=LcAFxc_sbYM');
Route::get('/r/md', [SocialController::class, 'redirectDiscordJoin']);
