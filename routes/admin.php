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


Route::get('/', [AdminController::class, 'index']);
$request = Request::capture();
//$path = ltrim($request->path(), '/');
$shorts = explode('/', $request->path());
$can = '';
switch (count($shorts)) {
    case 2:
        $can = $shorts[0].'.'. $shorts[1];
        break;
    case 3:
        $can = $shorts[0].'.'. $shorts[1].'.'. $shorts[2];
        break;
    case 4:
        $can = $shorts[0].'.'. $shorts[1].'.'. $shorts[3];
        break;
    default:
        $can = $shorts[0];
        break;
}
Route::resource('articles', ArticleController::class)->middleware('can:'.$can);
Route::resource('centers', CenterController::class)->middleware('can:'.$can);//->only(['index', 'create', 'edit', 'update']);
Route::resource('convocatories', ConvocatoryController::class)->middleware('can:'.$can);
Route::resource('events', EventController::class)->middleware('can:'.$can);
Route::resource('headers', HeaderController::class)->middleware('can:'.$can);
Route::resource('links', LinkController::class)->middleware('can:'.$can);
Route::resource('logs', LogAccessController::class)->middleware('can:'.$can);
Route::resource('news', NewsController::class)->middleware('can:'.$can);
Route::resource('users', UserController::class)->middleware('can:'.$can);

