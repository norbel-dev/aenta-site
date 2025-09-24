<?php

use App\Enums\Status;
use App\Http\Controllers\HomeController;
use App\Models\Article;
use App\Models\Center;
use App\Models\Event;
use App\Models\News;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('home');
// });

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });

Route::get('/', [HomeController::class, 'index']);
Route::get('/article', [HomeController::class, 'article'])->name('articles');
Route::get('/article/{article}', [HomeController::class, 'show_article'])->name('show_article');

Route::get('/center', [HomeController::class, 'center'])->name('centers');
Route::get('/center/{center}', [HomeController::class, 'show_center'])->name('show_center');

Route::get('/event', [HomeController::class, 'event'])->name('events');
Route::get('/event/{event}', [HomeController::class, 'show_event'])->name('show_event');

Route::get('/news', [HomeController::class, 'news'])->name('news');
Route::get('/news/{news}', [HomeController::class, 'show_news'])->name('show_news');
