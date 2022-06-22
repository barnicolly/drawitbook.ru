<?php

namespace App\Containers\SocialMediaPosting\Exceptions;

use Exception;

class NotFoundPictureIdForPostingException extends Exception
{
    protected $message = 'Не найден id изображения для постинга';
}
