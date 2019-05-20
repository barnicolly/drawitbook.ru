<?php

namespace App\UseCases\Picture;

use App\Entities\Picture\PictureModel;
use Illuminate\Support\Facades\Cache;
//use App\Http\Modules\Content\Controllers\Search;

class GetPicture
{

    private $_id;

    public function __construct(int $id)
    {
        $this->_id = $id;
    }

    public function get()
    {
        return PictureModel::with(['tags'])
            ->where('is_del', '=', 0)
            ->find($this->_id);
    }

}
