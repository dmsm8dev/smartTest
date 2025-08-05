<?php


use Illuminate\Support\Facades\Route;

Route::post('register', [\App\Http\Controllers\Auth\RegisterController::class, 'register']);
Route::post('login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->middleware('auth:sanctum');
