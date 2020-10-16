<?php

namespace App\Exceptions;

use Exception;

class NotFoundRelativeArts extends Exception
{
    protected $message = 'Не найдены подходяшие арты';
}
