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
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

$request = Request::capture();
$can = str_replace("/", ".", $request->path());
Route::get('/', [AdminController::class, 'index']);
Route::resource('articles', ArticleController::class)->middleware('can:'.$can);
Route::resource('centers', CenterController::class)->middleware('can:'.$can);//->only(['index', 'create', 'edit', 'update']);
Route::resource('convocatories', ConvocatoryController::class)->middleware('can:'.$can);
Route::resource('events', EventController::class)->middleware('can:'.$can);
Route::resource('headers', HeaderController::class)->middleware('can:'.$can);
Route::resource('links', LinkController::class)->middleware('can:'.$can);
Route::resource('logs', LogAccessController::class)->middleware('can:'.$can);
Route::resource('news', NewsController::class)->middleware('can:'.$can);
