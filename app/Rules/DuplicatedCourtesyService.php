<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class DuplicatedCourtesyService implements Rule
{

    public $services;
    public $service;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(array $services, array $service)
    {
        $this->services = $services;
        $this->service = $service;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        
        foreach($this->services as $service) {
            if ($service['courtesable_id'] == $this->service['courtesable_id'] && $service['courtesable_type'] == $this->service['courtesable_type']) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Serviço já incluído.';
    }
}
