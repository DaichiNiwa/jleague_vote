<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SurveyRequest extends FormRequest
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
            'question' => ['required', 'max:100'],
            'choice1' => ['required', 'max:50'],
            'choice2' => ['required', 'max:50'],
            'choice3' => ['required', 'max:50'],
            'choice4' => ['required', 'max:50'],
            'choice5' => ['required', 'max:50'],
            'close_at' => ['required', 'date_format:"Y-m-d"', 'after:tomorrow'],
        ];
    }
}
