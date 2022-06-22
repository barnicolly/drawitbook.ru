<?php

namespace App\Containers\Vk\Exceptions;

use Exception;

class NotFoundVkAlbumException extends Exception
{
    protected $message = 'Не найден VK альбом';
}
