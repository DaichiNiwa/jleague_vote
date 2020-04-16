<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MatchRequest extends FormRequest
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
            'tournament' => ['required', 'integer', 'min:0', 'max:2'],
            'tournament_sub' => ['nullable', 'integer', 'min:0', 'max:34'],
            'homeaway' => ['required', 'integer', 'min:0', 'max:1'],
            'team1_keyword' => ['required', 'max:20'],
            'team2_keyword' => ['required', 'max:20'],
            'match_date' => ['required', 'date_format:"Y-m-d"', 'after:yesterday'],
            'match_time' => ['required', 'date_format:"H:i"'],
            'reserve' => ['required', 'integer', 'min:0', 'max:1'],
            'reserve_date' => ['nullable', 'required_if:reserve, "1"', 'date_format:"Y-m-d"', 'before:match_date', 'after:today'],
            'reserve_time' => ['nullable', 'required_if:reserve, "1"', 'date_format:"H:00"'],
            'focus' => ['required', 'integer', 'min:0', 'max:1'],
        ];
    }
}
