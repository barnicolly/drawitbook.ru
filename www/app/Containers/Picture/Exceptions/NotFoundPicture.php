<?php

namespace App\Containers\Picture\Exceptions;

use Exception;

class NotFoundPicture extends Exception
{
    protected $message = 'Не найдено изображение';
}
