<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PackageItemRequest extends FormRequest
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
        return [
            'description' => 'required',
            'image' => 'required|mimes:jpeg,bmp,png,jpg|max:10240', // 2MB/ 2MB
            // 'image' => 'required',
            // 'reference' => 'required',
            'weight' => 'required',
            'amount' => 'required',
        ];
    }
}
