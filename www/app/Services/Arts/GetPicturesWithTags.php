<?php

namespace App\Services\Arts;

use App\Entities\Picture\PictureModel;

class GetPicturesWithTags
{

    private $_ids;

    public function __construct(array $ids)
    {
        $this->_ids = $ids;
    }

    public function get()
    {
        return PictureModel::with(['tags'])->whereIn('id', $this->_ids)->get();
    }

}
