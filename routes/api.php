<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\UserController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(["prefix" => "v1"], function(){
    Route::prefix('posts')->middleware('auth:user')->group(function () {
        Route::get('/', [PostController::class, 'index']);
        Route::post('/create', [PostController::class, 'create']);
    });

    Route::prefix('users')->group(function(){
        Route::post('/create', [UserController::class, 'signup']);
    });
    Route::prefix('auth')->group(function () {
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/signup', [AuthController::class, 'signup']);

        Route::middleware(['auth:admin, auth:user'])->group(function () {
            Route::post('/logout', [AuthController::class, 'logout']);
        });
    });
    Route::prefix('reset-password')->group(function(){
        Route::post('/', [ResetPasswordController::class, 'passwordReset']);
        Route::post('/mail', [ResetPasswordController::class, 'passwordResetMail']);
    });
});
