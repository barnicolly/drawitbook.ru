<?php

declare(strict_types=1);

namespace App\Containers\Picture\Exceptions;

use Exception;

class NotFoundPicture extends Exception
{
    /** @var string $message */
    protected $message = 'Не найдено изображение';
}
