<?php

use App\Http\Controllers\Api\MovieBoradcastController;
use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\MovieMovieBoradcastsController;
use Illuminate\Support\Facades\Route;

Route::apiResource('movies', MovieController::class);
Route::apiResource('movie-broadcasts', MovieBoradcastController::class);

Route::get('movies/{movie}/movie-broadcasts', [MovieMovieBoradcastsController::class, 'index'])->name('movies.movie-broadcasts.index');
Route::get('movies/{movie}/movie-broadcasts/{movie_broadcast}', [MovieMovieBoradcastsController::class, 'show'])->name('movies.movie-broadcasts.show');
Route::post('movies/{movie}/movie-broadcasts', [MovieMovieBoradcastsController::class, 'store'])->name('movies.movie-broadcasts.store');