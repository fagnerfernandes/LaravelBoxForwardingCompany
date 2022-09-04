<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OldPassword implements Rule
{
    private $table;
    private $id;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(String $table, String $id)
    {
        $this->table = $table;
        $this->id = $id;
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
        $data = DB::table($this->table)->find($this->id);
        return Hash::check($value, $data->password);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'A senha atual não está correta.';
    }
}
