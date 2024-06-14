<?php

namespace App\Http\Resources\Api;

use App\Models\MovieBroadcast;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieBroadcastResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => class_basename(MovieBroadcast::class),
            'id' => $this->id,
            'attributes' => [
                'movieId' => $this->movie_id, 
                'channelNr'=> $this->channel_nr,
                'broadcastsAt' => $this->broadcasts_at,
                $this->mergeWhen($request->routeIs('movie-broadcasts.*'), [
                    'createdAt' => $this->created_at,   
                    'updatedAt' => $this->updated_at,
                ]),
            ],
            'include' => $this->when($request->routeIs('movie-broadcasts.*'), new MovieResource($this->movie)),
            'links' => [
                'self' => route('movie-broadcasts.show', ['movie_broadcast' => $this->id]),
            ],
        ];
    }
}
