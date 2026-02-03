<?php

use App\Http\Controllers\Auth\AuthenticatedTokenController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Rotas de autenticações
Route::controller(AuthenticatedTokenController::class)->group(function () {
    Route::post('/login', 'store');
    Route::post('/logout', 'destroy')->middleware('auth:sanctum');
});

//Rotas autenticadas
Route::middleware(['auth:sanctum'])->group(function() {
    Route::get('/profile', function () {
        return response()->json(auth()->user());
    });

    Route::apiResource('/users', UserController::class);
    Route::delete('/users/{user}/hard-delete', [UserController::class, 'hardDelete']);
});

