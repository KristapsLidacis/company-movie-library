<?php

namespace App\Http\Resources\Api;

use App\Models\Movie;
use App\Models\MovieBroadcast;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieBroadcastResource extends JsonResource
{
    // Handles the transformation of a MovieBroadcast model into an array.

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Define the resource type and ID
        return [
            'type' => class_basename(MovieBroadcast::class),
            'id' => $this->id,
            'attributes' => [
                // Channel number attribute
                'channelNr'=> $this->channel_nr,
                // Broadcasts at attribute
                'broadcastsAt' => $this->broadcasts_at,
                // Conditionally add created and updated at timestamps
                $this->mergeWhen($request->routeIs('movie-broadcasts.*'), [
                    'createdAt' => $this->created_at,   
                    'updatedAt' => $this->updated_at,
                ]),
            ],
            'relationships' => [
                // Movie relationship
                'movie' => [
                    'data' => [
                        'type' => class_basename(Movie::class),
                        'id' => $this->movie_id
                    ],
                    // Movie self link
                    'self' => route('movies.show', ['movie' => $this->movie_id]),
                ],
            ],
            // Conditionally include the movie resource
            'include' => $this->when($request->routeIs('movie-broadcasts.*'), new MovieResource($this->movie)),
            'links' => [
                // Self link
                'self' => route('movie-broadcasts.show', ['movie_broadcast' => $this->id]),
            ],
        ];
    }
}
