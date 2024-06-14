<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MovieBroadcast;
use App\Http\Requests\API\MovieBroadcast\StoreMovieBroadcastRequest;
use App\Http\Requests\API\MovieBroadcast\UpdateMovieBroadcastRequest;
use App\Http\Resources\Api\MovieBroadcastResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MovieBoradcastController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return MovieBroadcastResource::collection(MovieBroadcast::paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMovieBroadcastRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($movie_broadcast_id)
    {
        try {
            $movieBroadcast = MovieBroadcast::findOrFail($movie_broadcast_id);

            return new MovieBroadcastResource($movieBroadcast);
        } catch (ModelNotFoundException $th) {
            return $this->ok('Movie could not be created', [
                'message' => 'Movie could not be created',
                'error' => 401,
            ]);
        }
    }
}
