<?php

use App\Http\Controllers\Auth\AuthenticatedTokenController;
use App\Http\Controllers\ExampleCRUDController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthenticatedTokenController::class, 'store']);
Route::post('/logout', [AuthenticatedTokenController::class, 'destroy'])->middleware('auth:sanctum');

Route::middleware(['auth:sanctum'])->group(function() {
    Route::prefix('/users')->controller(UserController::class)->group(function () {
        Route::get('/{user}', 'show');
        Route::put('/{user}', 'update');
    });
});

Route::middleware(['auth:sanctum', 'can:admin'])->group(function(){
    Route::apiResource('/users',UserController::class)->except(['update', 'show']);
    Route::delete('/users/hard-delete/{user}', [UserController::class, 'hardDelete']);
});

// Rotas do "EXAMPLECRUD", apenas para fins de teste.
// Route::middleware(['auth:sanctum'])->group(function(){
//     Route::apiResource('/exampleCRUD', ExampleCRUDController::class);
//     Route::delete('/exampleCRUD/hard-delete/{exampleCRUD}', [ExampleCRUDController::class, 'hardDelete']);
// });
