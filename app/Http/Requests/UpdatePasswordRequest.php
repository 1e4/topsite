<?php

namespace App\Http\Requests;

use App\Rules\OldPasswordConfirmed;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'new_password'  =>  [
                'required',
                'min:8',
                'confirmed'
            ],
            'new_password_confirmation' =>  [
                'required',
                'min:8'
            ],
            'current_password'  =>  [
                'required',
                'min:8',
                new OldPasswordConfirmed()
            ]
        ];
    }
}
