<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SettingRequest extends FormRequest
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
            'key' => 'required|unique:settings',
            'value' => 'required',
        ];

        if ($this->isMethod('PUT')) {

            $rules['key'] = [
                'required',
                Rule::unique('settings')->where(function($q) {
                    $q->where('id', '<>', $this->setting->id);
                }),
            ];
        }

        return $rules;
    }
}
