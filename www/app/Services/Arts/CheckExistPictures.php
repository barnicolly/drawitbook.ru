<?php

namespace App\Services\Arts;

use Illuminate\Database\Eloquent\Collection;

class CheckExistPictures
{

    private $_pictures;

    public function __construct(Collection $pictures)
    {
        $this->_pictures = $pictures;
    }

    public function check()
    {
        foreach ($this->_pictures as $key => $picture) {
            if (!checkExistArt($picture->path)) {
                $this->_pictures->forget($key);
                Log::info('Не найдено изображение', ['art' => $picture->toArray()]);
            }
        }
        return $this->_pictures;
    }

}

