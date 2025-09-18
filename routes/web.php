<?php

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

Route::get('/', function () {
    return view('home', [
        'center' => Center::first(),
        'news' => News::where('status', 'published')->latest()->take(3)->get(),
        'events' => Event::where('status', 'published')->orderBy('event_date', 'asc')->take(3)->get(),
        'articles' => Article::where('status', 'published')->latest()->take(2)->get(),
    ]);
});
