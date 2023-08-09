<?php

declare(strict_types=1);

namespace App\Containers\Vk\Exceptions;

use Exception;

final class NotFoundVkAlbumPictureException extends Exception
{
    /** @var string $message */
    protected $message = 'Не найдена связь изображения и альбома ВК';
}
