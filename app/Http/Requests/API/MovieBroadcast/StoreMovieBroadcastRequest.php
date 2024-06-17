<?php

namespace App\Http\Requests\API\MovieBroadcast;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovieBroadcastRequest extends FormRequest
{
    // Handles the validation rules for storing a movie broadcast.

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Define the validation rules for the request data
        $rules = [
            'data.attributes.channelNr' => 'required|integer', // Channel nr. must be a required integer
            'data.attributes.broadcastsAt' => 'required|date', // Broadcasts at must be a required date
        ];

        // If the request is for creating a new movie broadcast, add a rule for the movie ID
        if($this->routeIs('movie-broadcasts.store')){
            $rules['data.relationships.movie.data.id'] = 'required|integer'; // Movie id must be a required integer
        }

        // return rules array
        return $rules;
    }

    /**
     * Map the request attributes to a format suitable for storing a movie broadcast.
     *
     * @return array
     */
    public function attributeMap($movie_id = null): array
    {
        // Define the attribute mapping array
        $map = [
            'data.attributes.channelNr' => 'channel_nr',
            'data.attributes.broadcastsAt' => 'broadcasts_at',
            'data.relationships.movie.data.id' => 'movie_id'
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

        // If a movie ID is provided, add it to the mapped attributes
        if($movie_id){
            $mappedAttributes['movie_id'] = $movie_id;
        }

        // Return the array of mapped attributes
        return $mappedAttributes;
    }
}
