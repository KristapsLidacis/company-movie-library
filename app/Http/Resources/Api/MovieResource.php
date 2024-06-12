<?php

namespace App\Http\Resources\Api;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => class_basename(Movie::class),
            'id' => $this->id,
            'attributes' => [
                'title' => $this->title,
                'rating'=> $this->rating,
                'ageRestriction' => $this->age_restriction,
                $this->mergeWhen($request->routeIs('movies.*'), [
                    'description' => $this->description,
                    'premieresAt'=> $this->premieres_at,
                    'createdAt' => $this->created_at,   
                    'updatedAt' => $this->updated_at,
                ]),
            ],
            'links' => [
                'self' => route('movies.show', ['movie' => $this->id]),
            ],
        ];
    }
}
