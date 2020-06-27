<?php

namespace App\Http\Requests\Admin\UserRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class FilterUserRequest extends FormRequest
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
            'perpage' => 'required',
            'page' => 'required',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        return redirect()->back();
    }
}
