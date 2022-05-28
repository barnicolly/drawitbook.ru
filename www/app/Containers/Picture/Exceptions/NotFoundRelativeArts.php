<?php

namespace App\Containers\Picture\Exceptions;

use Exception;

class NotFoundRelativeArts extends Exception
{
    protected $message = 'Не найдены подходяшие арты';
}
