<?php

namespace App\Http\Controllers\Api;

use App\Models\Movie;
use App\Http\Requests\API\Movie\StoreMovieRequest;
use App\Http\Requests\API\Movie\UpdateMovieRequest;
use App\Http\Resources\Api\MovieResource;

class MovieController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Movie::query();

        if(request()->has('filter') && isset(request()->get('filter')['title'])){
            $likeStr = str_replace('*', '%', request()->get('filter')['title']);
            $query->where('title', 'like', $likeStr);
        }

        return MovieResource::collection($query->orderByDesc('created_at')->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMovieRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie)
    {
        return new MovieResource($movie);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMovieRequest $request, Movie $movie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie)
    {
        $movie->delete();

        return $this->ok('Movie deleted');    
    }
}
