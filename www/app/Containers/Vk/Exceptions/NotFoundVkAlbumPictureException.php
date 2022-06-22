<?php

namespace App\Containers\Vk\Exceptions;

use Exception;

class NotFoundVkAlbumPictureException extends Exception
{
    protected $message = 'Не найдена связь изображения и альбома ВК';
}
