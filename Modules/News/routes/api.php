<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\News\app\Http\Controllers\PostController;
use Modules\News\app\Http\Controllers\PostTranslationController;
use Modules\News\app\Http\Controllers\TagController;
use Modules\News\app\Models\Post;
use Modules\News\app\Resources\PostCollectionResource;

/*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
    |
*/

Route::resource('/news/tags', TagController::class);
Route::resource('/news/translations', PostTranslationController::class);
Route::get('/news/search', 'PostController@search');
Route::resource('/news', PostController::class);

