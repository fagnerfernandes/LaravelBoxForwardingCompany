<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PackageRequest extends FormRequest
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
            'name' => 'required',
            'customer_id' => 'required',
            'photo' => 'required|mimes:jpeg,bmp,png,jpg|max:10240', // 2MB
        ];

        if ($this->method() != 'POST') {
            unset($rules['photo']);
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'photo.mimes' => 'Você deve escolher um arquivo de imagem',
            'photo.max' => 'A foto precisa ter no máximo 2MB',
        ];
    }
}
