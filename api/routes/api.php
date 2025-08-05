<?php

use App\Http\Controllers\PdfResumeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], static function () {
    require __DIR__ . '/auth.php';
});


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('genres')->controller(\App\Http\Controllers\GenresController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
    Route::post('/create', 'store');
    Route::put('update/{id}', 'update');
    Route::delete('/delete/{id}', 'destroy');
});

Route::prefix('films')->controller(\App\Http\Controllers\FilmsController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
    Route::post('/create', 'store');
    Route::put('update/{id}', 'update');
    Route::delete('/delete/{id}', 'destroy');
});
