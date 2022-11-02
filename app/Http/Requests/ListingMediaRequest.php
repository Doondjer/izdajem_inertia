<?php

namespace App\Http\Requests;

use App\Rules\MinNbImagesRule;
use App\Rules\YoutubeRule;
use Illuminate\Foundation\Http\FormRequest;

class ListingMediaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'images' => new MinNbImagesRule(),
            'video_url' => ['nullable', 'sometimes', new YoutubeRule()],
        ];
    }
}
