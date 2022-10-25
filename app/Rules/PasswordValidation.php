<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class PasswordValidation implements Rule
{

    public $lengthPasses = true;

    public $specialCharPasses = true;
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->lengthPasses = (Str::length($value) >= 8);
        $this->specialCharPasses = ((bool) preg_match('/[^A-Za-z0-9]/', $value));
        return ($this->lengthPasses && $this->specialCharPasses);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        switch (true) {
            case ! $this->lengthPasses
                && $this->specialCharPasses:
                return 'Password must be at least 8 Characters.';
            case !$this->specialCharPasses
                && $this->lengthPasses:
                return 'Password must be at least one special character.';
            case !$this->lengthPasses
                && !$this->specialCharPasses:
                return 'Password must be at least 8 Characters and contain at least one special Character.';
            default:
                return 'Password must be at least 8 Characters';
        }
    }
}
