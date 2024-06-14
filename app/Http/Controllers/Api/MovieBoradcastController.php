<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MovieBroadcast;
use App\Http\Requests\API\MovieBroadcast\StoreMovieBroadcastRequest;
use App\Http\Requests\API\MovieBroadcast\UpdateMovieBroadcastRequest;
use App\Http\Resources\Api\MovieBroadcastResource;

class MovieBoradcastController extends Controller
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
    public function show(MovieBroadcast $movieBroadcast)
    {
        //
    }
}
