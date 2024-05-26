<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConsultationRequestController;
use App\Http\Controllers\PostsController;
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
Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'admin'], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::resource('/user-list', UserController::class);
    Route::resource('/request-list', ConsultationRequestController::class);
});
Route::post('/upload-image', [PostsController::class, 'uploadImage'])->name('upload-image');
