<?php

namespace App\Http\Requests;

use App\Models\PremiumService;
use Illuminate\Foundation\Http\FormRequest;

class PremiumShoppingRequest extends FormRequest
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
            'premium_service_id' => 'required',
            'package_item_id' => 'required',
        ];

        $service_id = $this->request->get('premium_service_id');
        if (PremiumService::isCustom($service_id)) {
            $rules['service_description'] = 'required';
        }
        return $rules;
    }
}
