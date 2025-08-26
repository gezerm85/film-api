<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TurController;
use App\Http\Controllers\KisiController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\OyuncuController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Tür routes
Route::apiResource('turler', TurController::class);

// Kişi routes
Route::apiResource('kisiler', KisiController::class);

// Film routes
Route::apiResource('filmler', FilmController::class);

// Oyuncu routes
Route::apiResource('oyuncular', OyuncuController::class);

// Ek film routes
Route::get('/filmler/tur/{tur_id}', [FilmController::class, 'getByTur']);
Route::get('/filmler/search/{query}', [FilmController::class, 'search']);
