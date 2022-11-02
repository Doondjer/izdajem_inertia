<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListingPublishRequest extends FormRequest
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
        return array_merge(
            (new ListingDetailsRequest())->rules(),
            (new ListingPriceRequest())->rules(),
            (new ListingDescriptionRequest())->rules(),
            (new ListingMediaRequest())->rules(),
            [
                'terms' => 'required|boolean'
            ]
        );
    }
}
