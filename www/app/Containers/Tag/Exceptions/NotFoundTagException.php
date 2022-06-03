<?php

namespace App\Containers\Tag\Exceptions;

use Exception;

class NotFoundTagException extends Exception
{
    protected $message = 'Не найден тэг';
}
