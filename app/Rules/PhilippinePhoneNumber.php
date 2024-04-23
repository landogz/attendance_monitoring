<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PhilippinePhoneNumber implements Rule
{
    public function passes($attribute, $value)
    {
        // Check if the phone number matches the Philippine phone number format
        // The format can vary, but generally, it's 11 digits starting with 0 or +63
        return preg_match('/^(0|\+63)[0-9]{10}$/', $value);
    }

    public function message()
    {
        return 'The :attribute must be a valid Philippine phone number in the format 09xxxxxxxxx.';
    }
}
