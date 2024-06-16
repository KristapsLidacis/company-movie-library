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
    // This class handles requests related to movie broadcasts

     /**
     * The policy class to use for authorization
     *
     * @var string
     */
    protected $policyClass = MovieBroadcastPolicy::class;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        // Get paginated all movie broadcasts results that are scheduled for a future date and then order the results by the broadcast date and return results
        return MovieBroadcastResource::collection(MovieBroadcast::whereDate('broadcasts_at', '>=', Carbon::now())->orderBy('broadcasts_at')->paginate());
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @return MovieBroadcastResource
     * @throws AuthorizationException If the user is not authorized to create a movie broadcast
     */
    public function store(StoreMovieBroadcastRequest $request)
    {
        try { 

            // Find the movie with the given ID. If the movie is not found, throw a ModelNotFoundException
            Movie::findOrFail($request->input('data.relationships.movie.data.id'));

            // Check if the user is authorized to create a movie broadcast. If not, throw an AuthorizationException
            $this->isAble('store', MovieBroadcast::class);

            // Create a new movie broadcast with the given data and return a new MovieBroadcastResource with the created movie broadcast
            return new MovieBroadcastResource(MovieBroadcast::create($request->attributeMap()));

        } catch (ModelNotFoundException $th) {

            // Return a message if catched ModelNotFoundException
            return $this->ok('Movie broadcast not found', [
                'message' => 'Movie broadcast not found',
                'error' => 401,
            ]);
        } catch (AuthorizationException $ex){
            
            // Return a message if catched AuthorizationException
            return $this->ok('Unauthorized', [
                'error' => 'You are missing create privilages',
                'status' => 401
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @return MovieBroadcastResource
     * @throws AuthorizationException If the user is not authorized to view the movie broadcast
     */
    public function show($movie_broadcast_id)
    {
        try {
            
            // Find the movie broadcast with the given ID. If the movie broadcast is not found, throw a ModelNotFoundException
            $movieBroadcast = MovieBroadcast::findOrFail($movie_broadcast_id);

            // Check if the user is authorized to view the movie broadcast. If not, throw an AuthorizationException
            $this->isAble('show', $movieBroadcast);

            // Return a new MovieBroadcastResource with the movie broadcast
            return new MovieBroadcastResource($movieBroadcast);

        } catch (ModelNotFoundException $th) {

            // Return a message if catched ModelNotFoundException
            return $this->ok('Movie broadcast not found', [
                'message' => 'Movie broadcast not found',
                'error' => 401,
            ]);
        } catch (AuthorizationException $ex){
            
            // Return a message if catched AuthorizationException
            return $this->ok('Unauthorized', [
                'error' => 'You are missing view privilages',
                'status' => 401
            ]);
        }
    }
}
