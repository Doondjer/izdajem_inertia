<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListingFeaturesRequest extends FormRequest
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
            'amenities' => 'array',
            'amenities.*' => 'bail|sometimes|exists:amenities,name',
            'securities.*' => 'bail|sometimes|exists:securities,name',
        ];
    }
}
