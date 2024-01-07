<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\ProductsController;

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

Route::prefix('v1')->group(function () {
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::middleware(['auth:pos'])->group(function () {
        Route::get('/me', [AuthController::class, 'getUser']);
        Route::get('/refresh', [AuthController::class, 'refreshToken']);
        Route::get('/logout', [AuthController::class, 'logout']);

        Route::apiResource("products", ProductsController::class);
    });
});
