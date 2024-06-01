<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\ConsultationRequestController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\PostsTypeController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::middleware('throttle:1,1')->group(function () {
//    Route::resource('/consultation-request', ConsultationRequestController::class);
//});
Route::resource('/consultation-request', ConsultationRequestController::class);
Route::post('/admin/login', [AuthController::class, 'login'])->name('login');
Route::get('/admin/posts', [PostsController::class, 'index']);
Route::get('/admin/posts/{post}/edit', [PostsController::class, 'edit']);
Route::get('/admin/category', [PostsTypeController::class, 'index']);
Route::get('/admin/banner', [BannerController::class, 'index'])->name('banner.index');
Route::get('/admin/menu', [MenuController::class, 'index'])->name('menu.index');


Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'admin'], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::resource('/user-list', UserController::class);
    Route::resource('/request-list', ConsultationRequestController::class);

    Route::get('/posts/create', [PostsController::class, 'create']);
    Route::post('/posts', [PostsController::class, 'store']);
    Route::get('/posts/{post}', [PostsController::class, 'show']);
    Route::put('/posts/{post}', [PostsController::class, 'update']);
    Route::delete('/posts/{post}', [PostsController::class, 'destroy']);

    Route::get('/category/create', [PostsTypeController::class, 'create']);
    Route::post('/category', [PostsTypeController::class, 'store']);
    Route::get('/category/{category}', [PostsTypeController::class, 'show']);
    Route::get('/category/{category}/edit', [PostsTypeController::class, 'edit']);
    Route::put('/category/{category}', [PostsTypeController::class, 'update']);
    Route::delete('/category/{category}', [PostsTypeController::class, 'destroy']);

    Route::get('/banner/create', [BannerController::class, 'create'])->name('banner.create');
    Route::post('/banner', [BannerController::class, 'store'])->name('banner.store');
    Route::get('/banner/{banner}', [BannerController::class, 'show'])->name('banner.show');
    Route::get('/banner/{banner}/edit', [BannerController::class, 'edit'])->name('banner.edit');
    Route::put('/banner/{banner}', [BannerController::class, 'update'])->name('banner.update');
    Route::post('/banner/delete', [BannerController::class, 'destroy'])->name('banner.destroy');


    Route::get('/menu/create', [MenuController::class, 'create'])->name('menu.create');
    Route::post('/menu', [MenuController::class, 'store'])->name('menu.store');
    Route::get('/menu/{menu}', [MenuController::class, 'show'])->name('menu.show');
    Route::get('/menu/{menu}/edit', [MenuController::class, 'edit'])->name('menu.edit');
    Route::put('/menu/{menu}', [MenuController::class, 'update'])->name('menu.update');
    Route::delete('/menu/{menu}', [MenuController::class, 'destroy'])->name('menu.destroy');
});
Route::post('/upload-image', [PostsController::class, 'uploadImage'])->name('upload-image');
