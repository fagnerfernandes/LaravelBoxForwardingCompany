<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PremiumServiceRequest extends FormRequest
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
            'name' => 'required|unique:premium_services',
            'price' => 'required',
        ];

        if ((bool)$this->request->get('need_description')) {
            unset($rules['price']);
        }

        if ($this->isMethod('PUT')) {
            $rules['name'] = [
                'required',
                Rule::unique('premium_services')->where(function($q) {
                    $q->where('id', '<>', $this->premium_service->id);
                }),
            ];
        }

        return $rules;

    }
}
