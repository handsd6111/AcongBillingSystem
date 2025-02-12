<?php

use App\Http\Controllers\AuthController;
use App\Http\Middleware\CustomAuthenticate;
use App\Http\Middleware\CustomResponse;
use Illuminate\Http\Request;
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


Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::patch("/token/refresh", [AuthController::class, 'refreshToken']);

Route::middleware([CustomAuthenticate::class])->group(function () {

});
