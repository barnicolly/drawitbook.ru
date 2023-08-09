<?php

declare(strict_types=1);

namespace App\Containers\SocialMediaPosting\Exceptions;

use Exception;

class NotFoundPictureIdForPostingException extends Exception
{
    /** @var string $message */
    protected $message = 'Не найден id изображения для постинга';
}
