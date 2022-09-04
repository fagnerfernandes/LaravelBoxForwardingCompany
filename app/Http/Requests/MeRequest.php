<?php

namespace App\Http\Requests;

use App\Rules\OldPassword;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class MeRequest extends FormRequest
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
        // dd($this->all());
        $rules = [
            'user.name' => 'required',
            'user.email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->where('id', '<>', Auth::user()->id)
            ],
            'document' => 'required|cpf',
        ];

        if ($this->has('user.password') && !empty($this->get('user')['password'])) {
            $rules += [
                'user.password' => 'required|confirmed|min:6',
                'user.password_confirmation' => 'required',
                'user.old_password' => ['required', new OldPassword('users', Auth::user()->id)],
            ];
        }

        if ($this->has('user.avatar') && !empty($this->avatar)) {
            $rules[] = [
                'user.avatar' => 'image'
            ];
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'user.name.required' => 'Por favor informe seu nome',
            'user.email.required' => 'Por favor informe o email',
            'user.email.email' => 'Por favor informe um email válido',
            'user.name.unique' => 'Já existe outro usuário com este email',
            'document.required' => 'Por favor informe seu CPF/CNPJ',
            'user.old_password.required' => 'Por favor informe a senha atual',
            'user.password.required' => 'Por favor informe a senha',
            'user.password.confirmed' => 'A senha e a confirmação não conferem',
            'user.password.min' => 'A senha deve conter no mínimo 6 caracteres',
            'user.password_confirmation.required' => 'Por favor repita a senha',
        ];
    }
}
