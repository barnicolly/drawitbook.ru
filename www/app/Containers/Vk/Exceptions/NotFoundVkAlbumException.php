<?php

declare(strict_types=1);

namespace App\Containers\Vk\Exceptions;

use Exception;

final class NotFoundVkAlbumException extends Exception
{
    /** @var string $message */
    protected $message = 'Не найден VK альбом';
}
