<?php

namespace App\Containers\Tag\Exceptions;

use Exception;

class NotFoundTagException extends Exception
{
    /** @var string $message */
    protected $message = 'Не найден тэг';
}
