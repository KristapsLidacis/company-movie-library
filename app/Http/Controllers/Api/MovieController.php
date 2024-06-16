<?php

namespace App\Http\Controllers\Api;

use App\Models\Movie;
use App\Http\Requests\API\Movie\StoreMovieRequest;
use App\Http\Requests\API\Movie\UpdateMovieRequest;
use App\Http\Resources\Api\MovieResource;
use App\Policies\MoviePolicy;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MovieController extends ApiController
{
    // This class handles requests related to movies

    /**
     * The policy class to use for authorization
     *
     * @var string     */
    protected $policyClass = MoviePolicy::class;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        // Get the movie query builder
        $query = Movie::query();

         // Check if a filter parameter is present
        $filter = request()->has('filter') ? request()->get('filter') : null;

        // If a filter parameter is present and it has a title key, add a "where like" clause to the query to filter movies by title
        if($filter && isset($filter['title'])) {
            $likeStr = str_replace('*', '%', $filter['title']);
            $query->where('title', 'like', $likeStr);
        }

        // Order the results by the creation date in descending order, paginate the results and return a new MovieResource
        return MovieResource::collection($query->orderByDesc('created_at')->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return MovieResource
     * @throws AuthorizationException If the user is not authorized to create a movie
     */
    public function store(StoreMovieRequest $request)
    {
        try {

            // Check if the user is authorized to create a movie, if not, throw an AuthorizationException
            $this->isAble('store', Movie::class);

            // Create a new movie with the given data. Return a new MovieResource with the created movie
            return new MovieResource(Movie::create($request->attributeMap()));

        } catch (\Throwable $th) {

            // Return a message if catched Throwable
            return $this->ok('Movie could not be created', [
                'message' => 'Movie could not be created',
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
     * @return MovieResource
     * @throws AuthorizationException If the user is not authorized to view the movie
     */
    public function show($movie_id)
    {
        try {

            // Find the movie with the given ID. If the movie is not found, throw a ModelNotFoundException
            $movie = Movie::findOrFail($movie_id);

            // Check if the user is authorized to view the movie. If not, throw an AuthorizationException
            $this->isAble('show', $movie);

            // Return a new MovieResource with the movie
            return new MovieResource($movie);

        } catch (ModelNotFoundException $th) {

            // Return a message if catched Throwable
            return $this->ok('Movie not found', [
                'message' => 'Movie not found',
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
    
     /**
     * Update the specified resource in storage.
     *
     * @return MovieResource
     * @throws AuthorizationException If the user is not authorized to update the movie
     */
    public function update(UpdateMovieRequest $request, $movie_id)
    {
        try {

            // Try to find the movie with the given ID. If the movie is not found, throw a ModelNotFoundException
            $movie = Movie::findOrFail($movie_id);

            // Check if the user is authorized to update the movie. If not, throw an AuthorizationException
            $this->isAble('update', $movie);

            //Updates movie values
            $movie->update($request->attributeMap());

            // Return a new MovieResource with the movie
            return new MovieResource($movie);

        } catch (ModelNotFoundException $th) {

            // Return a message if catched Throwable
            return $this->ok('Movie not found', [
                'error' => 'Movie not found',
                'status' => 401
            ]);
        } catch (AuthorizationException $ex){

            // Return a message if catched AuthorizationException
            return $this->ok('Unauthorized', [
                'error' => 'You are missing update privilages',
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

            // Try to find the movie with the given ID. If the movie is not found, throw a ModelNotFoundException
            $movie = Movie::findOrFail($movie_id);

            // Check if the user is authorized to delete the movie. If not, throw an AuthorizationException
            $this->isAble('destroy', $movie);

            // Delete the movie
            $movie->delete();

            // Return a successful response with a "Movie deleted" message
            return $this->ok('Movie deleted');

        } catch (ModelNotFoundException $th) {

            // Return a message if catched Throwable
            return $this->ok('Movie not found', [
                'error' => 'Movie not found',
                'status' => 401
            ]);
        } catch (AuthorizationException $ex){

            // Return a message if catched AuthorizationException
            return $this->ok('Unauthorized', [
                'error' => 'You are missing delete privilages',
                'status' => 401
            ]);
        }
    }
}
