<?php

namespace App\Containers\Vk\Exceptions;

use Exception;

class NotFoundVkAlbumPictureException extends Exception
{
    /** @var string $message */
    protected $message = 'Не найдена связь изображения и альбома ВК';
}
