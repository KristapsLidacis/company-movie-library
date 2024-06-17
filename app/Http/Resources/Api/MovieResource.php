<?php

namespace App\Http\Resources\Api;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
    // Handles the transformation of a Movie model into an array.

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Define the resource type and ID  
        return [
            'type' => class_basename(Movie::class),
            'id' => $this->id,
            'attributes' => [
                // Title attribute
                'title' => $this->title,
                // Rating attribute
                'rating'=> $this->rating,
                // Age restriction attribute
                'ageRestriction' => $this->age_restriction,
                // Conditionally add description, premieres at, created at, and updated at attributes
                $this->mergeWhen($request->routeIs('movies.*'), [
                    'description' => $this->description,
                    'premieresAt'=> $this->premieres_at,
                    'createdAt' => $this->created_at,   
                    'updatedAt' => $this->updated_at,
                ]),
            ],
            // Conditionally include movie broadcasts
            'includes' => $this->when($request->routeIs('movies.*'), function(){
                 // Get the movie broadcasts and paginate them
                $movieBroadcastResource = MovieBroadcastResource::collection($this->movieBroadcasts()->paginate(10))->resource;

                 // Return the movie broadcasts if they exist, otherwise an empty array
                return $movieBroadcastResource->isNotEmpty() ? $movieBroadcastResource : [];
            }),
            'links' => [
                // Self link
                'self' => route('movies.show', ['movie' => $this->id]),
            ],
        ];
    }
}
