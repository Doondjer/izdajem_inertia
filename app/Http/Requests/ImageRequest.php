<?php

namespace App\Http\Requests;

use App\Rules\MaxNbImagesRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class ImageRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'image' => [
                'required',
                'image',
                new MaxNbImagesRule(),
                'max:5000'
                ]// Max velicina slike se mora promeniti i na front endu
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => __('exception.The given data was invalid'),
            'error' => $validator->errors()->first()
        ], Response::HTTP_UNPROCESSABLE_ENTITY));
    }

}
