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
            ],
            'include' => new MovieResource($this->movie),
            'links' => [
                'self' => route('movie-broadcasts.show', ['movie_broadcast' => $this->id]),
            ],
        ];
    }
}
