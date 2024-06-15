<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\API\MovieBroadcast\StoreMovieBroadcastRequest;
use App\Http\Resources\Api\MovieBroadcastResource;
use App\Models\Movie;
use App\Models\MovieBroadcast;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Carbon;

class MovieMovieBoradcastsController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index($movie_id)
    {
        return MovieBroadcastResource::collection(
            MovieBroadcast::where('movie_id', $movie_id)
            ->whereDate('broadcasts_at', '>=', Carbon::now())
            ->orderBy('broadcasts_at')
            ->paginate());
    }

     /**
     * Display the specified resource.
     */
    public function show($movie_id, $movie_broadcast_id)
    {
        $movieBroadcast = MovieBroadcast::find($movie_broadcast_id);

        if($movieBroadcast && $movieBroadcast->movie_id == $movie_id){
            return new MovieBroadcastResource($movieBroadcast);
        }

        return $this->error('Movie broadcast not found for this movie', 404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($movie_id, StoreMovieBroadcastRequest $request)
    {
        $movie = Movie::find($movie_id);

        if(!$movie){
            return $this->error('Movie not found', 404);
        }
        
        return new MovieBroadcastResource(MovieBroadcast::create($request->attributeMap($movie_id)));
    }
}
