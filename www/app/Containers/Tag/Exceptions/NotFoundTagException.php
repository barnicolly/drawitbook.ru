<?php

declare(strict_types=1);

namespace App\Containers\Tag\Exceptions;

use Exception;

final class NotFoundTagException extends Exception
{
    /** @var string $message */
    protected $message = 'Не найден тэг';
}
