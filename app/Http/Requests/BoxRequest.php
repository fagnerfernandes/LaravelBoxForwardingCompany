<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BoxRequest extends FormRequest
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
            'name'      => 'required',
            'depth'     => 'required',
            'width'     => 'required',
            'height'    => 'required',
        ];

        if ($this->isMethod('PUT')) {

            $rules['name'] = [
                'required',
                Rule::unique('boxes')->where(function($q) {
                    $q->where('id', '<>', $this->box->id);
                }),
            ];
        }

        return $rules;
    }
}
