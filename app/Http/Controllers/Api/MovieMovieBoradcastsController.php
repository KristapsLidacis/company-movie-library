<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\API\MovieBroadcast\StoreMovieBroadcastRequest;
use App\Http\Resources\Api\MovieBroadcastResource;
use App\Models\Movie;
use App\Models\MovieBroadcast;
use App\Policies\MovieBroadcastPolicy;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Carbon;

class MovieMovieBoradcastsController extends ApiController
{
    protected $policyClass = MovieBroadcastPolicy::class;

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
        try {
            $movieBroadcast = MovieBroadcast::findOrFail($movie_broadcast_id);

            $this->isAble('show', $movieBroadcast);

            if($movieBroadcast->movie_id != $movie_id){
                return $this->error('Movie broadcast not found for this movie', 404);
            }
            return new MovieBroadcastResource($movieBroadcast);

        } catch (ModelNotFoundException $th) {
            return $this->ok('Movie broadcast not found', [
                'message' => 'Movie broadcast not found',
                'error' => 404,
            ]);
        } catch (AuthorizationException $ex){
            return $this->ok('Unauthorized', [
                'error' => 'You are missing view privilages',
                'status' => 401
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($movie_id, StoreMovieBroadcastRequest $request)
    {
        try {
            
            Movie::findOrFail($movie_id);
            
            $this->isAble('store', MovieBroadcast::class);
            
            return new MovieBroadcastResource(MovieBroadcast::create($request->attributeMap($movie_id)));

        } catch (ModelNotFoundException $th) {
            return $this->ok('Movie could not be found', [
                'message' => 'Movie could not be found',
                'error' => 401,
            ]);
        } catch (AuthorizationException $ex){
            return $this->ok('Unauthorized', [
                'error' => 'You are missing create privilages',
                'status' => 401
            ]);
        }
    }
}
