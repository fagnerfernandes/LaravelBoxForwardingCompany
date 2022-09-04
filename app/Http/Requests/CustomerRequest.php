<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerRequest extends FormRequest
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
        $rules = [
            'user.name' => 'required',
            'user.email' => 'required|email|unique:users,email',
            'user.password' => 'required|confirmed',
        ];
        if ($this->isMethod('PUT')) {
            $rules['user.email'] = [
                'required',
                'email',
                Rule::unique('users', 'email')->where('id', $this->id),
            ];

            $rules['user.password'] = 'confirmed';
        }
        return $rules;
    }
}
