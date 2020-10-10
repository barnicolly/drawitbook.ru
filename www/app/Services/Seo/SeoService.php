<?php

namespace App\Services\Arts;

class SeoService
{

    public function __construct()
    {

    }

    public function formTitleAndDescriptionShowArt(int $artId): array
    {
        $title = 'Art #' . $artId . ' | Drawitbook.ru';
        $description = 'Главное при рисовании по клеточкам придерживаться пропорций будущей картинки. У вас обязательно всё получится.';
        return [$title, $description];
    }

}


