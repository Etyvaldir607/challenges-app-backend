<?php

use App\Http\Controllers\ChessGameController;
use App\Http\Controllers\StringValueGameController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/problem-1', [ChessGameController::class, 'queensAttack']);
Route::post('/problem-2', [StringValueGameController::class, 'maxValue']);

