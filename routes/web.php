<?php

use App\Http\Controllers\Admin\AnnouncementsController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ChangePassword;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\LinksController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\TagsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
      //auth
      Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
      Route::post('/login', [AuthController::class, 'login'])->name('login');
      
      
      Route::group(['prefix' => 'admin','middleware' => 'auth'],function (){
            // Dashboard
            Route::get('/',[HomeController::class,'index'])->name('admin-index');
      
            //auth
            Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
      
            //settings
            Route::get('/settings',[SettingController::class,'edit'])->name('edit-setting');
            Route::patch('/settings/{setting}',[SettingController::class,'update'])->name('update-setting');
      
            //menu-groups
            Route::get('/menu-groups', [MenuController::class, 'groups'])->name('menus');
            Route::patch('/menu/sort', [MenuController::class, 'sortMenus'])->name('menu.sort');
            Route::resource('/menus',MenuController::class);
      
            //announcements
            Route::resource('announcements',AnnouncementsController::class);
      
            //posts
            Route::resource('posts',PostsController::class);
            // Route::get('/posts/search',[PostsController::class,'search'])->name('admin-posts-search');
      
            //profile
            Route::get('/profile/{user}', [ProfileController::class,'edit'])->name('admin-profile-edit');
            Route::put('/profile/{user}',[ProfileController::class,'update'])->name('admin-profile-update');
      
            Route::put('/changepassword/{user}',[ChangePassword::class,'ChangePassword'])->name('change-password');
      
            //articles
            Route::resource('articles',ArticleController::class);
            Route::post('/articles/search',[ArticleController::class,'search'])->name('admin-articles-search');
      
            //sliders
            Route::resource('sliders',SliderController::class);

            //links
            Route::resource('links',LinksController::class);

            //categories 
            Route::resource('categories',CategoryController::class);
      
            //tags 
            Route::resource('tags',TagsController::class);

      });

