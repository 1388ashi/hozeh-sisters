<?php

use App\Http\Controllers\Api\announcementController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\LinkController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\SliderController;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::name('api.')->prefix('front')->group(function () {
    //menu*
    Route::get('/menus', [MenuController::class,'index'])->name('menus.index');
    
    //posts*
    Route::get('/news', [PostController::class,'index'])->name('news.index');
    Route::get('/news/{news}', [PostController::class,'show'])->name('news.show');

    //articles*
    Route::get('/articles', [ArticleController::class,'index'])->name('articles.index');
    Route::get('/articles/{article}', [ArticleController::class,'show'])->name('articles.show');
    
    //links*
    Route::get('/links', [LinkController::class,'index'])->name('links.index');
    
    //announcements*
    Route::get('/announcements', [announcementController::class,'index'])->name('announcements.index');
    Route::get('/announcements/{announcements}', [announcementController::class,'show'])->name('announcements.show');
    
    //sliders*
    Route::get('/sliders', [SliderController::class,'index'])->name('sliders.index');
    
    //settings*
    Route::get('/settings', [SettingController::class,'index'])->name('settings.index');
    
    //categories*
    Route::get('/categories', [CategoryController::class,'index'])->name('categories.index');
});