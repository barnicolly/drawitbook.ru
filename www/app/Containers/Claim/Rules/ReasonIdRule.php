<?php

namespace App\Containers\Claim\Rules;

use Illuminate\Contracts\Validation\Rule;

class ReasonIdRule implements Rule
{
    private $reasonIds = [1, 2, 3, 4, 5];

    public function __construct()
    {
    }

    public function passes($attribute, $value)
    {
        return in_array((int) $value, $this->reasonIds, true);
    }

    public function message()
    {
        return 'Причина должна соответствовать одному из значений: ' . implode(', ', $this->reasonIds);
    }
}
