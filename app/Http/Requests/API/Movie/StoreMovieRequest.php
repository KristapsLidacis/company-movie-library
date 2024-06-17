<?php

namespace App\Http\Requests\API\Movie;

class StoreMovieRequest extends BaseMovieRequest
{
    // This request is used to validate and authorize store movie requests.

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
        // Define the validation rules for the request attributes
        return [
            'data.attributes.title' => 'required|string|max:100', // Title must be a required string with a maximum length of 100 characters
            'data.attributes.description' => 'required|string|max:500', // Description must be a required string with a maximum length of 500 characters
            'data.attributes.ageRestriction' => 'sometimes|max:2|in:7,12,16', // Age restriction must be sometimes present, with a maximum length of 2 characters, and must be one of the specified values (7, 12, or 16)
            'data.attributes.rating' => 'required|decimal:1', // Rating must be a required decimal value with one digit after the decimal point
            'data.attributes.premieresAt' => 'required|date', // Premieres at must be a required date value
        ];
    }
}
