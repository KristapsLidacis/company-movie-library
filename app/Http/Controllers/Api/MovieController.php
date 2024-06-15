<?php

namespace App\Http\Controllers\Api;

use App\Models\Movie;
use App\Http\Requests\API\Movie\StoreMovieRequest;
use App\Http\Requests\API\Movie\UpdateMovieRequest;
use App\Http\Resources\Api\MovieResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MovieController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Movie::query();

        $filter = request()->has('filter') ? request()->get('filter') : null;
        if($filter && isset($filter['title'])) {
            $likeStr = str_replace('*', '%', $filter['title']);
            $query->where('title', 'like', $likeStr);
        }

        return MovieResource::collection($query->orderByDesc('created_at')->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMovieRequest $request)
    {
        try {
            return new MovieResource(Movie::create($request->attributeMap()));

        } catch (\Throwable $th) {
            return $this->ok('Movie could not be created', [
                'message' => 'Movie could not be created',
                'error' => 401,
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($movie_id)
    {
        try {
            $movie = Movie::findOrFail($movie_id);

            return new MovieResource($movie);

        } catch (ModelNotFoundException $th) {

            return $this->ok('Movie not found', [
                'message' => 'Movie not found',
                'error' => 401,
            ]);
        }
    }
    
     /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMovieRequest $request, $movie_id)
    {
        try {
            $movie = Movie::findOrFail($movie_id);

            $movie->update($request->attributeMap());

            return new MovieResource($movie);

        } catch (ModelNotFoundException $th) {
            return $this->ok('Movie not found', [
                'error' => 'Movie not found',
                'status' => 401
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($movie_id)
    {
        try {
            $movie = Movie::findOrFail($movie_id);
            $movie->delete();

            return $this->ok('Movie deleted');

        } catch (ModelNotFoundException $th) {

            return $this->ok('Movie not found', [
                'error' => 'Movie not found',
                'status' => 401
            ]);
        }
    }
}
