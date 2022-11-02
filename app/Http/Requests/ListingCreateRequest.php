<?php

namespace App\Http\Requests;

use App\Rules\LatitudeRule;
use App\Rules\LongitudeRule;
use Illuminate\Foundation\Http\FormRequest;

class ListingCreateRequest extends FormRequest
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
            'city'          => 'required|string',
            'county'        => 'sometimes|nullable|string',
            'country'       => 'sometimes|nullable|string',
            'district'      => 'sometimes|nullable|string',
            'postal_code'   => 'sometimes|nullable|numeric',
            'street'        => 'required|string',
            'street_nb'     => 'sometimes|string|nullable',
            'latitude'      => ['required', new LatitudeRule()],
            'location_id'   => 'nullable|sometimes|string|max:70',
            'longitude'     => ['required', new LongitudeRule()],
        ];
    }
}
