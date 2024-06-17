<?php

namespace App\Http\Requests\API\Movie;

class UpdateMovieRequest extends BaseMovieRequest
{
    // Handles the validation rules for updating a movie.

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
        return [
            'data.attributes.title' => 'sometimes|string|max:100', // Title must be sometimes present string with a maximum length of 100 characters
            'data.attributes.description' => 'sometimes|string|max:500', // Description must be  sometimes present string with a maximum length of 500 characters
            'data.attributes.ageRestriction' => 'sometimes|max:2|in:7,12,16', // Age restriction must be sometimes present, with a maximum length of 2 characters, and must be one of the specified values (7, 12, or 16)
            'data.attributes.rating' => 'sometimes|decimal:1', // Rating must be sometimes present decimal value with one digit after the decimal point
            'data.attributes.premieresAt' => 'sometimes|date', // Premieres at must be sometimes present date value
        ];
    }
}
