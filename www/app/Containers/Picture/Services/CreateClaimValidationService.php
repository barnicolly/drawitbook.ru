<?php

namespace App\Containers\Picture\Services;

use App\Containers\Picture\Rules\ReasonIdRule;
use Validator;

class CreateClaimValidationService
{

    public function __construct()
    {
    }

    public function validate(array $data): bool
    {
        $validator = Validator::make(
            $data,
            [
                'id' => 'required|integer',
                'reason' => [
                    'required',
                    new ReasonIdRule(),
                ],
            ]
        );
        return !$validator->fails();
    }

}


