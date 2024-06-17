<?php

namespace App\Http\Requests\API\Movie;

use Illuminate\Foundation\Http\FormRequest;

class BaseMovieRequest extends FormRequest
{
    // Base request for movie-related API requests.

    /**
     * Maps API request attributes to model attributes.
     *
     * @return array
     */
    public function attributeMap(): array
    {
        // Define the attribute mapping array
        $map = [
            'data.attributes.title' => 'title',
            'data.attributes.description' => 'description',
            'data.attributes.ageRestriction' => 'age_restriction',
            'data.attributes.rating' => 'rating',
            'data.attributes.premieresAt' => 'premieres_at',
        ];

        // Initialize an empty array to store the mapped attributes
        $mappedAttributes = [];

        // Loop through the attribute mapping array
        foreach($map as $key => $attribute){

            // Check if the request has the specified key
            if($this->has($key)){
                
                // Add the mapped attribute to the array
                $mappedAttributes[$attribute] = $this->input($key);
            }
        }

        // Return the array of mapped attributes
        return $mappedAttributes;
    }
}
