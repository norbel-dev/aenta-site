<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\CenterController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\NewsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AdminController::class, 'index']);

Route::resource('news', NewsController::class);
Route::resource('events', EventController::class);
Route::resource('centers', CenterController::class);//->only(['index', 'create', 'edit', 'update']);
Route::resource('articles', ArticleController::class);
