<?php

namespace App\Http\Requests\API\MovieBroadcast;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovieBroadcastRequest extends FormRequest
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
            'data.attributes.channelNr' => 'required|integer',
            'data.attributes.broadcastsAt' => 'required|date',
            'data.relationships.movie.id' => 'required|integer',
        ];
    }

    public function attributeMap(): array
    {
        $map = [
            'data.attributes.channelNr' => 'channel_nr',
            'data.attributes.broadcastsAt' => 'broadcasts_at',

            'data.relationships.movie.id' => 'movie_id'
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
