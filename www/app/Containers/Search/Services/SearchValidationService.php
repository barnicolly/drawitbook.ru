<?php

namespace App\Containers\Search\Services;

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


