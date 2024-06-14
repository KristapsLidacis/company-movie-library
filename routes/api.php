<?php

use App\Http\Controllers\Api\MovieBoradcastController;
use App\Http\Controllers\Api\MovieController;
use Illuminate\Support\Facades\Route;

Route::apiResource('movies', MovieController::class);
Route::apiResource('movie-broadcasts', MovieBoradcastController::class);