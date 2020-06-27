<?php

namespace App\Http\Requests\Api\Shop;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class RegisterRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'phone' => 'required|min:6|max:12'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        return response()->json([
            'code' => Response::HTTP_BAD_REQUEST,
            'message' => 'Validation failed',
        ]);
    }
}
