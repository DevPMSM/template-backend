<?php

use App\Http\Controllers\Auth\AuthenticatedTokenController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });

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


