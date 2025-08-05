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
