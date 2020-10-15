<?php

namespace App\Services\Validation;

use Illuminate\Validation\Rule;
use Validator;

class SearchValidationService
{

    public function __construct()
    {
    }

    public function validate(array $data): bool
    {
        $validator = Validator::make($data,
            [
                'query' => 'string|max:255',
                'similar' => 'int',
                'tags' => 'array',
                'tags.*' => 'string',
            ]
        );
        return !$validator->fails();
    }

}


