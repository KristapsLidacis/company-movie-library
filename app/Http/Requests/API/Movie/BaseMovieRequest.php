<?php

namespace App\Http\Requests\API\Movie;

use Illuminate\Foundation\Http\FormRequest;

class BaseMovieRequest extends FormRequest
{
    public function attributeMap(): array
    {
        $map = [
            'data.attributes.title' => 'title',
            'data.attributes.description' => 'description',
            'data.attributes.ageRestriction' => 'age_restriction',
            'data.attributes.rating' => 'rating',
            'data.attributes.premieresAt' => 'premieres_at',
        ];

        $mappedAttributes = [];
        foreach($map as $key => $attribute){
            if($this->has($key)){
                $mappedAttributes[$attribute] = $this->input($key);
            }
        }

        return $mappedAttributes;
    }
}
