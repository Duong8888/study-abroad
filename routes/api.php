<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\ConsultationRequestController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\PostsTypeController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UniversityController;
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
Route::group(['prefix' => 'admin'], function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/posts', [PostsController::class, 'index']);
    Route::get('/posts/{post}/edit', [PostsController::class, 'edit']);
    Route::get('/category', [PostsTypeController::class, 'index']);
    Route::get('/banner', [BannerController::class, 'index'])->name('banner.index');
    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
    Route::get('/team', [TeamController::class, 'index']);
    Route::get('/university', [UniversityController::class, 'index']);
});
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
    Route::get('/category/{post}', [PostsTypeController::class, 'show']);
    Route::put('/category/{post}', [PostsTypeController::class, 'update']);
    Route::delete('/category/{post}', [PostsTypeController::class, 'destroy']);

    Route::get('/team/create', [TeamController::class, 'create']);
    Route::post('/team', [TeamController::class, 'store']);
    Route::get('/team/{post}', [TeamController::class, 'show']);
    Route::put('/team/{post}', [TeamController::class, 'update']);
    Route::delete('/team/{post}', [TeamController::class, 'destroy']);

    Route::get('/team/create', [TeamController::class, 'create']);
    Route::post('/team', [TeamController::class, 'store']);
    Route::get('/team/{post}', [TeamController::class, 'show']);
    Route::post('/team/{post}', [TeamController::class, 'update']);
    Route::delete('/team/{post}', [TeamController::class, 'destroy']);

    Route::get('/university/create', [UniversityController::class, 'create']);
    Route::post('/university', [UniversityController::class, 'store']);
    Route::get('/university/{university}', [UniversityController::class, 'show']);
    Route::get('/university/{university}/edit', [UniversityController::class, 'edit']);
    Route::post('/university/{university}', [UniversityController::class, 'update']);
    Route::delete('/university/{university}', [UniversityController::class, 'destroy']);

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

    Route::get('/profile', [UserController::class, 'showProfile']);
    Route::post('/profile', [UserController::class, 'updateProfile']);
    Route::post('/profile/change-password', [UserController::class, 'changePassword']);
});
Route::post('/upload-image', [PostsController::class, 'uploadImage'])->name('upload-image');
