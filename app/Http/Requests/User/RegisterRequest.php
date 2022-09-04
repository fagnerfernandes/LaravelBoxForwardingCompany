<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:users', 'confirmed'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'document' => ['required', 'string', 'cpf', 'unique:customers'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Nome é obrigatório',
            'name.string' => 'O campo de nome é alfa numérico',
            'name.max' => 'O campo nome aceita no máximo 255 caracteres',
            'email.required' => 'O campo email é obrigatório',
            'email.email' => 'Email inválido',
            'email.unique' => 'Já existe uma conta com este email',
            'email.confirmed' => 'O email e a confirmação não conferem',
            'password.required' => 'A senha é obrigatória',
            'password.confirmed' => 'A senha e a confirmação não conferem',
            'document.required' => 'O CPF é obrigatório',
            'document.cpf' => 'CPF inválido',
            'document.unique' => 'CPF já cadastrado',
        ];
    }

}
