<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NoteController;
use App\Http\Controllers\Api\UserController;
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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

// test route
Route::get('ping', function () {
    return ['pong' => true];
});

// auth
Route::controller(AuthController::class)->prefix('auth')->name('auth.')->middleware(['auth:api'])->group(function () {
    Route::post('login', 'login')->name('login')->withoutMiddleware('auth:api');
    Route::post('logout', 'logout')->name('logout');
    Route::post('refresh', 'refresh')->name('refresh');
    Route::get('me', 'me')->name('me');
});

Route::apiResource('notas', NoteController::class)->names('notes')->parameter('notas', 'note')->middleware(['auth:api']);

Route::apiResource('usuarios', UserController::class)->names('users')->parameter('usuarios', 'user')->middleware(['auth:api']);
