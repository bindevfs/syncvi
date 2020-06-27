<?php

namespace App\Http\Requests\Admin\AdminRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class RegisterAdminRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|min:8',
            're-password' => 'required|same:password',
            'phone' => 'required|min:6|max:12'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        return redirect()->back();
    }
}
