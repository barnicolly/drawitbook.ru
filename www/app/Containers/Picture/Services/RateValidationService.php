<?php

namespace App\Containers\Picture\Services;

use Illuminate\Validation\Rule;
use Validator;

class RateValidationService
{

    public function __construct()
    {
    }

    public function validate(array $data): bool
    {
        $validator = Validator::make($data, [
            'id' => 'required|integer',
            'off' => [
                'required',
                Rule::in(['true', 'false']),
            ]
        ]);
        return !$validator->fails();
    }

}


