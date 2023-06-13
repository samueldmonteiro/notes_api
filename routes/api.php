<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NoteController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

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
Route::get('usuarios', [UserController::class, 'index'])->name('users.index')->middleware(['auth:api', 'isAdmin']);
Route::post('usuarios', [UserController::class, 'store'])->name('users.store');
