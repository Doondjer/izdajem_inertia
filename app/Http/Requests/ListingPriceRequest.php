<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListingPriceRequest extends FormRequest
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
            'available_from'    => 'required|date:Y-m-d',
            'deposit'           => 'nullable|integer|min:0|max:100000',
            'price'             => 'required|integer|min:0',
        ];
    }
}
