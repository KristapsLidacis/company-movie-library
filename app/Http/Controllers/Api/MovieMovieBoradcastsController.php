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
    //Controller for managing movie broadcasts.

    /**
     * The policy class for MovieBroadcast.
     *
     * @var string
     */
    protected $policyClass = MovieBroadcastPolicy::class;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index($movie_id)
    {
        // Retrieve movie broadcasts for the given movie ID
        // with a paginated list of movie broadcasts for a given movie
        // that have a broadcast date and time greater than or equal to the current time.
        // The list is sorted by the broadcast date and time in ascending order.
        // Return a collection of MovieBroadcastResource objects
        return MovieBroadcastResource::collection(
            MovieBroadcast::where('movie_id', $movie_id)
            ->whereDate('broadcasts_at', '>=', Carbon::now())
            ->orderBy('broadcasts_at')
            ->paginate()
        );
    }

    /**
     * Display the specified resource.
     *
     * @return MovieBroadcastResource
     * @throws ModelNotFoundException If the movie broadcast is not found.
     * @throws AuthorizationException If the user is not authorized to view the movie broadcast.
     */
    public function show($movie_id, $movie_broadcast_id)
    {
        try {
            
            // Retrieve the movie broadcast by its ID and movie ID. If the movie is not found, throw a ModelNotFoundException
            $movieBroadcast = MovieBroadcast::where('id', $movie_broadcast_id)
                ->where('movie_id', $movie_id)
                ->firstOrFail();

            // Check if the user is authorized to view the movie broadcast. If not, throw an AuthorizationException
            $this->isAble('show', $movieBroadcast);

            // Return a MovieBroadcastResource object
            return new MovieBroadcastResource($movieBroadcast);

        } catch (ModelNotFoundException $th) {

            // Return a message if catched Throwable
            return $this->ok('Movie broadcast not found', [
                'message' => 'Movie broadcast not found',
                'error' => 404,
            ]);
        } catch (AuthorizationException $ex) {

            // Return a 404 error message if the movie broadcast is not found
            return $this->ok('Unauthorized', [
                'error' => 'You are missing view privilages',
                'status' => 401
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @return MovieBroadcastResource
     * @throws ModelNotFoundException If the movie is not found.
     * @throws AuthorizationException If the user is not authorized to create a movie broadcast.
     */
    public function store(StoreMovieBroadcastRequest $request, $movie_id)
    {
        try {

            // Retrieve the movie by its ID. If the movie is not found, throw a ModelNotFoundException
            Movie::findOrFail($movie_id);

            // Check if the user is authorized to create a movie broadcast. If not, throw an AuthorizationException
            $this->isAble('store', MovieBroadcast::class);

            // Create a new movie broadcast with the provided attributes and Return a MovieBroadcastResource object
            return new MovieBroadcastResource(MovieBroadcast::create($request->attributeMap($movie_id)));

        } catch (ModelNotFoundException $th) {

            // Return a message if catched ModelNotFoundException
            return $this->ok('Movie could not be found', [
                'message' => 'Movie could not be found',
                'error' => 401,
            ]);
        } catch (AuthorizationException $ex) {

            // Return a message if catched AuthorizationException
            return $this->ok('Unauthorized', [
                'error' => 'You are missing create privilages',
                'status' => 401
            ]);
        }
    }
}
