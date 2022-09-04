<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'password' => ['required', 'confirmed'],
        ];
    }

    public function messages()
    {
        return [
            'password.required' => 'Por favor informe a nova senha',
            'password.confirmed' => 'A nova senha e a confirmação não conferem',
        ];
    }
}
