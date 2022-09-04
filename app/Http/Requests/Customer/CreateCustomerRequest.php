<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class CreateCustomerRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'user.name' => 'required',
            'user.email' => 'required|email|unique:users,email',
            'user.password' => 'required|confirmed',
            'document' => 'required|string|cpf|unique:customers',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'user.name' => 'Nome',
            'user.email' => 'Email',
            'document' => 'CPF',
            'user.password' => 'Senha'
        ];
    }
}
