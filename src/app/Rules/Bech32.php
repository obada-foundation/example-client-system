<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;
use App\Extensions\Kielabokkie\AddressValidator;

class Bech32 implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        if (! (new AddressValidator)->isBech32($value)){
            $fail('The :attribute must be valid OBADA address.');
        }
    }
}
