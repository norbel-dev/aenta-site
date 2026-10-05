<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LandingPageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingPageController::class, 'index'])->name('index');

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

// Route::get('/', [HomeController::class, 'index']);
Route::get('/article', [HomeController::class, 'article'])->name('articles');
Route::get('/article/{article}', [HomeController::class, 'show_article'])->name('show_article');

Route::get('/center', [HomeController::class, 'center'])->name('centers');
Route::get('/center/{center}', [HomeController::class, 'show_center'])->name('show_center');

Route::get('/event', [HomeController::class, 'events'])->name('events');
Route::get('/event/{event}', [HomeController::class, 'showEvent'])->name('show_event');

Route::get('/headers', [HomeController::class, 'headers'])->name('headers');
Route::get('/headers/{header}', [HomeController::class, 'showHeader'])->name('show_header');

Route::get('/news', [HomeController::class, 'news'])->name('news');
Route::get('/news/{news}', [HomeController::class, 'show_news'])->name('show_news');
