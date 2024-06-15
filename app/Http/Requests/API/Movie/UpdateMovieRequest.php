<?php

namespace App\Http\Requests\API\Movie;

class UpdateMovieRequest extends BaseMovieRequest
{
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
        return [
            'data.attributes.title' => 'sometimes|string|max:100',
            'data.attributes.description' => 'sometimes|string|max:500',
            'data.attributes.ageRestriction' => 'sometimes|max:2|in:7,12,16',
            'data.attributes.rating' => 'sometimes|decimal:1',
            'data.attributes.premieresAt' => 'sometimes|date',
        ];
    }
}
