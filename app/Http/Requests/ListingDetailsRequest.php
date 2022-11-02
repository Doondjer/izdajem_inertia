<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListingDetailsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nb_floor' => 'required|integer|min:-1|max:30',
            'nb_room' => 'required|in:' . implode(',', array_keys(config('app_settings.values.structure'))),
            'size' => 'nullable|sometimes|integer',
            'total_floor' => 'nullable|sometimes|integer|min:0|max:30|gte:nb_floor',
            'type' => 'required|in:' . implode(',', array_keys(config('app_settings.values.types'))),
            'furnish_type' => 'required|in:' . implode(',', array_keys(config('app_settings.values.furnish_types'))),
        ];
    }
}
