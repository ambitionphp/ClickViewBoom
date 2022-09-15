<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers;

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

Route::prefix('v1')->middleware(['auth:api', 'ability:read', 'json.response'])->group(function() {
    Route::get('/user', [Controllers\ApiController::class, 'user']);
    Route::get('/recent', [Controllers\ApiController::class, 'recent']);
    Route::post('/secret', [Controllers\ApiController::class, 'secret']);
    Route::post('/boom', [Controllers\ApiController::class, 'boom']);
    Route::middleware(['throttle:12,1'])->post('/create', [Controllers\ApiController::class, 'create']);
});
