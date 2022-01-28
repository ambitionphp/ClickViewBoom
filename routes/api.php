<?php

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

Route::middleware(['auth:sanctum', 'ability:read', 'json.response'])->group(function() {
    Route::get('/user', [\App\Http\Controllers\ApiController::class, 'user']);
    Route::get('/recent', [\App\Http\Controllers\ApiController::class, 'recent']);
    Route::get('/secret/{text}', [\App\Http\Controllers\ApiController::class, 'secret']);
    Route::get('/boom/{text}', [\App\Http\Controllers\ApiController::class, 'boom']);
    Route::middleware(['throttle:create'])->post('/create', [\App\Http\Controllers\ApiController::class, 'create']);
});
