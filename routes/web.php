<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'team'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/mastodon', [App\Http\Controllers\MastodonController::class, 'index'])->name('mastodon');
Route::get('/twitter', [App\Http\Controllers\TwitterController::class, 'index'])->name('twitter');
Route::get('/social-media', [App\Http\Controllers\SocialMediaController::class, 'index'])->name('social-media');

Route::get('/social-media', [App\Http\Controllers\SocialMediaController::class, 'index']);
Route::get('/show/{id}', [App\Http\Controllers\SocialMediaController::class, 'show']);
Route::get('/create', [App\Http\Controllers\SocialMediaController::class, 'create']);

Route::get('/scrape', [App\Http\Controllers\ScrapeController::class, 'scrape']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
