<?php

namespace App\Http\Requests\Admin\ShopUserRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class DisableShopUserRequest extends FormRequest
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
            'shopuser_id' => 'required'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        return redirect()->back();
    }
}
