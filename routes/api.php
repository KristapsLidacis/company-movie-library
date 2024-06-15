<?php

use App\Http\Controllers\Api\MovieBoradcastController;
use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\MovieMovieBoradcastsController;
use Illuminate\Support\Facades\Route;

Route::apiResource('movies', MovieController::class);

Route::get('movie-broadcasts', [MovieBoradcastController::class, 'index'])->name('movie-broadcasts.index');
Route::get('movie-broadcasts/{movie_broadcast}', [MovieBoradcastController::class, 'show'])->name('movie-broadcasts.show');
Route::post('movie-broadcasts', [MovieBoradcastController::class, 'store'])->name('movie-broadcasts.store');

Route::get('movies/{movie}/movie-broadcasts', [MovieMovieBoradcastsController::class, 'index'])->name('movies.movie-broadcasts.index');
Route::get('movies/{movie}/movie-broadcasts/{movie_broadcast}', [MovieMovieBoradcastsController::class, 'show'])->name('movies.movie-broadcasts.show');
Route::post('movies/{movie}/movie-broadcasts', [MovieMovieBoradcastsController::class, 'store'])->name('movies.movie-broadcasts.store');