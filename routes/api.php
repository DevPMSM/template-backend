<?php

use App\Http\Controllers\Auth\AuthenticatedTokenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(AuthenticatedTokenController::class)->group(function () {
    Route::post('/login', 'store');
    Route::post('/logout', 'destroy')->middleware('auth:sanctum');
});

Route::middleware(['auth:sanctum'])->get('/profile', function (Request $request) {
    return $request->user();
});
