<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExtraServiceRequest extends FormRequest
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
            'name' => 'required|unique:extra_services',
            'price' => 'required',
        ];

        if ($this->isMethod('PUT')) {
            $rules['name'] = [
                'required',
                Rule::unique('extra_services')->where(function($q) {
                    $q->where('id', '<>', $this->extra_service->id);
                }),
            ];
        }

        return $rules;
    }
}
