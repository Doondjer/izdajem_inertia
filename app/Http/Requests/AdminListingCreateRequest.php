<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminListingCreateRequest extends FormRequest
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
            (new ListingCreateRequest())->rules(),
            [
                'user_id' => 'required|exists:users,id',
                'source_url'        => 'nullable|active_url'
            ]);
    }
}
