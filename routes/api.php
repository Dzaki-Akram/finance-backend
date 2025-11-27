<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout',          [AuthController::class, 'logout']);
    Route::get('/user',             [AuthController::class, 'me']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);


    Route::put('/user/profile', [UserController::class, 'updateProfile']);


    Route::get('/transactions',                    [TransactionController::class, 'index']);
    Route::post('/transactions',                   [TransactionController::class, 'store']);
    Route::get('/transactions/{transaction}',      [TransactionController::class, 'show']);
    Route::put('/transactions/{transaction}',      [TransactionController::class, 'update']);
    Route::delete('/transactions/{transaction}',   [TransactionController::class, 'destroy']);
});
