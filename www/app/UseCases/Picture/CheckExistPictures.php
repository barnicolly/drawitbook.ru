<?php

namespace App\UseCases\Picture;

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
            if (!file_exists(base_path('public/arts/') . $picture->path)) {
                $this->_pictures->forget($key);
                Log::info('Не найдено изображение', ['art' => $picture->toArray()]);
            }
        }
        return $this->_pictures;
    }

}

