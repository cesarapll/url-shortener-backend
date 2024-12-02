<?php

use App\Http\Controllers\ShortenedUrlController;
use Illuminate\Support\Facades\Route;

Route::post('/shortened-urls', [ShortenedUrlController::class, 'create']);
Route::get('/shortened-urls', [ShortenedUrlController::class, 'list']);
Route::get('/shortened-urls/{code}', [ShortenedUrlController::class, 'getOriginalUrl']);
Route::delete('/shortened-urls/{id}', [ShortenedUrlController::class, 'delete']);
