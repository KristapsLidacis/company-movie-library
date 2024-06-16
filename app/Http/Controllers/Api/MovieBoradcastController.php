<?php

namespace App\Http\Controllers\Api;

use App\Models\MovieBroadcast;
use App\Http\Requests\API\MovieBroadcast\StoreMovieBroadcastRequest;
use App\Http\Resources\Api\MovieBroadcastResource;
use App\Models\Movie;
use App\Policies\MovieBroadcastPolicy;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Carbon;

class MovieBoradcastController extends ApiController
{
    protected $policyClass = MovieBroadcastPolicy::class;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return MovieBroadcastResource::collection(MovieBroadcast::whereDate('broadcasts_at', '>=', Carbon::now())->orderBy('broadcasts_at')->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMovieBroadcastRequest $request)
    {
        try {
            Movie::findOrFail($request->input('data.relationships.movie.data.id'));

            $this->isAble('store', MovieBroadcast::class);

            return new MovieBroadcastResource(MovieBroadcast::create($request->attributeMap()));

        } catch (AuthorizationException $ex){
            return $this->ok('Unauthorized', [
                'error' => 'You are missing create privilages',
                'status' => 401
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($movie_broadcast_id)
    {
        try {
            $movieBroadcast = MovieBroadcast::findOrFail($movie_broadcast_id);

            $this->isAble('show', $movieBroadcast);

            return new MovieBroadcastResource($movieBroadcast);
        } catch (ModelNotFoundException $th) {
            return $this->ok('Movie broadcast not found', [
                'message' => 'Movie broadcast not found',
                'error' => 401,
            ]);
        } catch (AuthorizationException $ex){
            return $this->ok('Unauthorized', [
                'error' => 'You are missing view privilages',
                'status' => 401
            ]);
        }
    }
}
