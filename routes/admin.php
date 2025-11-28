<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\CenterController;
use App\Http\Controllers\Admin\ConvocatoryController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\HeaderController;
use App\Http\Controllers\Admin\LinkController;
use App\Http\Controllers\Admin\LogAccessController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Middleware\EnsureUserIsAdmin;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;


Route::get('/', [AdminController::class, 'index'])->name('dashboard');
Route::resource('articles', ArticleController::class);
Route::resource('centers', CenterController::class);
Route::resource('convocatories', ConvocatoryController::class);
Route::resource('events', EventController::class);
Route::resource('headers', HeaderController::class);
Route::resource('links', LinkController::class);
Route::resource('logs', LogAccessController::class);
Route::resource('news', NewsController::class);
Route::resource('users', UserController::class);

