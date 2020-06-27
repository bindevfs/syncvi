<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class OrderRequest extends FormRequest
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
            'order_products' => 'required',
            'shipping_name' => 'required',
            'shipping_address' => 'required',
            'shipping_phone' => 'required'
        ];
    }

    /**
     * @param Validator $validator
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function failedValidation(Validator $validator)
    {
        return response()->json([
            'code' => Response::HTTP_BAD_REQUEST,
            'message' => 'Validation failed',
        ]);
    }
}
