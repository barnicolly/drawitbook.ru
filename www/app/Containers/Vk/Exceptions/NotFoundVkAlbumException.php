<?php

namespace App\Containers\Vk\Exceptions;

use Exception;

class NotFoundVkAlbumException extends Exception
{
    /** @var string $message */
    protected $message = 'Не найден VK альбом';
}
