<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\PostController;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // API routes for Post.
    Route::apiResource('posts', PostController::class);

    // API routes for Category.
    Route::apiResource('categories', CategoryController::class);
    Route::get('categories/{category}/posts', [CategoryController::class, 'getPosts']);
});

Route::post('/login', [AuthController::class, 'login']);
