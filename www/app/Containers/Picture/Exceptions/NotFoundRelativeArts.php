<?php

namespace App\Containers\Picture\Exceptions;

use Exception;

class NotFoundRelativeArts extends Exception
{
    /** @var string $message */
    protected $message = 'Не найдены подходяшие арты';
}
