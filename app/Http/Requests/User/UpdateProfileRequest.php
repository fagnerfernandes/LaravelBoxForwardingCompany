<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
           'name' => 'required',
           'email' => "required|email|unique:users,email,".$this->id,
           'password' => 'sometimes|nullable|confirmed|current_password:web',
           'avatar' => 'sometimes|image'
        ];
    }

    /* Get custom messages for validator errors.
    *
    * @return array
    */
   public function messages()
   {
        return [
            'password.current_password' => 'A senha atual não confere'
        ];
   }
}
