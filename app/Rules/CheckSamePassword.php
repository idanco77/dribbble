<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class CheckSamePassword implements Rule
{
    public function __construct()
    {
        //
    }

    public function passes($attribute, $value)
    {
        return !Hash::check($value, auth()->user()->password);
    }

    public function message()
    {
        return 'Your new password must be different from the current password';
    }
}
