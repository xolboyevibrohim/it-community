<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'phone'=>'required|regex:/^(998)([0-9]{9})$/',
            'password'=>'required|string'
        ];
    }
    public function failedValidation($validator){
        failedValidation($validator);
    }
}
