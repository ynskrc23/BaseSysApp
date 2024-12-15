<?php
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::apiResource('users', UserController::class);

// Yeni rota tanımları
Route::post('users/activeUsers', [UserController::class, 'activeUsers']);
