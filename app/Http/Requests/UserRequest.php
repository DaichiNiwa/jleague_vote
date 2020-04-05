<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => ['sometimes', 'required', 'regex:/^[a-zA-Z0-9]+$/i', 'max:255', 'unique:users,name'],
            'password' => ['required', 'regex:/^[a-zA-Z0-9]+$/i', 'min:8', 'confirmed'],
            ];
    }
}
