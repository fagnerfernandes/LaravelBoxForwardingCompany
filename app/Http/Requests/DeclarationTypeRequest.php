<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeclarationTypeRequest extends FormRequest
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
            'name' => 'required|unique:declaration_types',
        ];

        if ($this->isMethod('PUT')) {
            $rules['name'] = [
                'required',
                Rule::unique('declaration_types')->where(function($q) {
                    $q->where('id', '<>', $this->declaration_type->id);
                }),
            ];
        }

        return $rules;
    }
}
